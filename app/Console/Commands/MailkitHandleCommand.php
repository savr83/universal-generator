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
     */
    public function handle()
    {
        print("Get emails using IMAP...\n");

        $tempDir = sys_get_temp_dir() . '/mailkit_attach';
        if (!is_dir($tempDir)) mkdir($tempDir);
        print("Temporary directory is: $tempDir\n");

        foreach (Pool::where('enabled', true)->get() as $pool){
            print("Handling pool: {$pool->name}\n");

            foreach ($pool->sources()->where('enabled', true)->get() as $source) {
                print("Handling source: {$source->name}\n");

                $mailbox = new Mailbox($source->connection, $source->login, $source->password, $tempDir);
                // https://tools.ietf.org/html/rfc3501#section-9
                // date('j-M-Y') -1 day
                $criteria = $source->lastmail_id ? 'SINCE ' . date('j-M-Y', strtotime($source->lastmail_id . ' -1 day')) : 'ALL';
                print("Searching criteria: $criteria\n");
                $mailsIds = $mailbox->searchMailbox($criteria);

                foreach($mailsIds as $id) {
                    $mail = $mailbox->getMail($id, false);

                    if ($source->lastmail_id && $mail->date <= $source->lastmail_id) {
                        print("Mail already handled (from: {$mail->fromAddress} date: {$mail->date}) SKIPPED!\n");
                        continue;
                    }

                    $rule = $pool->active_rules->get()->sortByDesc('priority')->first();

                    foreach ($pool->filters()->where('enabled', true) as $filter) {
                        switch($this->filterMail($filter, $mail)){
                            case Filter::ACTION_SEND:
                                $linked_filter = new Filter();
                                $linked_filter->mail_field = "fromAddress";
                                $linked_filter->regexp = "/{$mail->fromAddress}/";
                                $linked_filter->action = Filter::ACTION_REPLY;
                                $linked_filter->pool()->associate($pool);
                                $linked_filter->rule()->associate($rule);
                                $linked_filter->save();
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
                    print("mail from: {$mail->fromAddress} added using rule: {$rule->name} with priority: {$rule->priority}\n");
                    dump($mail);
                    Mail::to($rule->recipient_list)->send(new ForwardedMail($source->login, $source->password, $mail));
                    $log = new Log();
                    $log->from = $mail->fromAddress;
                    $log->to = $rule->recipient_list;
                    $log->result = "Ok";
                    $log->pool_name = $pool->name;
                    $log->rule()->associate($rule);
                    $log->save();
                    $rule->increment('counter');

                    print("Updating marker: \n");
                    $source->lastmail_id = $mail->date;
                    $source->save();
                }
            }
        }
    }

    public function filterMail($filter, $mail)
    {
        print("Checking mail filter: {$filter->name}\n");
        $ret = (preg_match($filter->regexp, $mail[$filter->mail_field])) ? $filter->action : Filter::ACTION_DEFAULT;
        print("Filter action: $ret\n");
        return $ret;
    }
}
