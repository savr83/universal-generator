<?php

namespace App\Console\Commands;

use App\Mail\Mailkit\ForwardedMail;
use App\Mailkit\Filter;
use App\Mailkit\Log;
use App\Mailkit\Pool;
use App\Mailkit\Rule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use PhpImap\Mailbox;
use Swift_Mailer;
use Swift_SmtpTransport;

class MailkitHandleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailkit:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle incoming emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     *   {imap.beget.com:143/imap}INBOX
     *   {imap.beget.com:993/imap/ssl}INBOX
     *
     * @return mixed
     * @throws \PhpImap\Exception
     */
    public function handle()
    {
        print("Start handling emails\n");

        $tempDir = sys_get_temp_dir() . '/mailkit_attach';
        if (!is_dir($tempDir)) mkdir($tempDir);

        foreach (Pool::where('enabled', true)->get() as $pool){
            print("Handling pool: {$pool->name}\n");

            foreach ($pool->sources()->where('enabled', true)->get() as $source) {
                print("Handling source: {$source->name}\n");

                /**
                 * Changing SMTP transport will ignore any other possible mail configs
                 */

                print("Set up new SMTP transport: host: " . config('mail.host') . " port: " . config('mail.port') . " encryption: " . config('mail.encryption') . "\n");
                $transport = new Swift_SmtpTransport(config('mail.host'), config('mail.port'), config('mail.encryption'));
                $transport->setUsername($source->login);
                $transport->setPassword($source->password);
                Mail::setSwiftMailer(new Swift_Mailer($transport));

                $mailbox = new Mailbox($source->connection, $source->login, $source->password, $tempDir);

                /**
                 * https://tools.ietf.org/html/rfc3501#section-9
                 * date('j-M-Y')
                 * '-1 day' removed
                 */
                $criteria = $source->lastmail_id ? 'SINCE ' . date('j-M-Y', strtotime($source->lastmail_id)) : 'ALL';
                print("Searching criteria: $criteria\n");
                $mailsIds = $mailbox->searchMailbox($criteria);

                foreach($mailsIds as $id) {
// 2do: check method sortMails() instead of getMail() due to possible bug with mail list
                    $mail = $mailbox->getMail($id, false);

                    print("lastmail_id {$source->lastmail_id} mail->data{$mail->date} if: " . ($source->lastmail_id && ($mail->date <= $source->lastmail_id)));
                    if ($log = Log::where(['message_id' => $mail->id])->first()) {
//                    if ($source->lastmail_id && $mail->date <= $source->lastmail_id) {
                        print("Mail already handled (from: {$mail->fromAddress} date: {$mail->date}) SKIPPED!\n");
                        continue;
                    }

                    $calculatedRule = true;
                    $rule = $pool->active_rules->get()->sortByDesc('priority')->first();

                    if ($existingLog = Log::where(['pool_name' => $pool->name, 'from' => $mail->fromAddress])->orderBy('updated_at')->first()) {
                        print("Found existing rule!!!\n");
                        $rule = $existingLog->rule;
                        $calculatedRule = false;
                    }

                    foreach ($pool->filters as $filter) {
                        switch($this->filterMail($filter, $mail)){
                            case Filter::ACTION_SEND:
                                $rule = $filter->rule();
                                break;
                            case Filter::ACTION_REPLY:
                                $rule = $filter->rule();
                                break;
                            case Filter::ACTION_REJECT:
                                $rule = $pool->defaultRule();
                                break;
                            case Filter::ACTION_DEFAULT:
                            default:
                                $rule = $pool->defaultRule();
                                break;
                        }
                    }

                    /***
                     * empty fromAddress issue 02.02.2019
                     */
                    if (!$mail->fromAddress) {
                        print("mail DOESN'T containf from field!!");
                        dump($mail);
                        continue;
                    }
                    print("mail from: {$mail->fromAddress} added using rule: {$rule->name} with priority: {$rule->priority}\n");
                    dump($mail);

                    Mail::to($rule->recipient_list)->send(new ForwardedMail($source->login, $mail));
                    $log = new Log();
                    $log->from = $mail->fromAddress;
                    $log->to = $rule->recipient_list;
                    $log->result = "Ok";
                    $log->pool_name = $pool->name;
                    $log->message_id = $mail->id;
                    $log->rule()->associate($rule);
                    $log->save();
                    if ($calculatedRule) {
                        $rule->timestamps = false;
                        $rule->increment('counter');
                    }

                    print("Updating marker: {$mail->date}\n");
                    $source->lastmail_id = $mail->date;
                    $source->save();
                }
            }
        }
        print("Finish handling mail\n");
        print("Remove all attachments from: $tempDir\n");
        array_map("unlink", glob($tempDir . "/*"));
    }

    public function filterMail($filter, $mail)
    {
        print("Checking mail filter: {$filter->name}\n");
        $ret = (preg_match($filter->regexp, $mail[$filter->mail_field])) ? $filter->action : Filter::ACTION_DEFAULT;
        print("Filter action: $ret\n");
        return $ret;
    }
}
