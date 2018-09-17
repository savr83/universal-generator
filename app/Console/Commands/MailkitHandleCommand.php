<?php

namespace App\Console\Commands;

use App\Mailkit\Filter;
use App\Mailkit\Pool;
use App\Mailkit\Rule;
use Illuminate\Console\Command;
use InfiniteIterator;
use PhpImap\Mailbox;
use SplPriorityQueue;

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
     *   $mailbox = new Mailbox('{imap.beget.com:143/imap}INBOX', 'zakaz-rostov', 'NsOxD5v%', __DIR__);
     *   $mailbox = new Mailbox('{imap.beget.com:993/imap/ssl}INBOX', 'zakaz-rostov@agregat.me', 'NsOxD5v%');
     *
     * @return mixed
     */
    public function handle()
    {
        print("Get emails using IMAP...\n");
        foreach (Pool::where('enabled', true)->get() as $pool){
            print("Handling pool: {$pool->name}\n");

//            $queue = new SplPriorityQueue();
            Rule::$currentRuleSet = $pool->rules()->where('enabled', true)->orderBy('weight', 'desc');
            Rule::$currentRuleSet->update(['counter' => 0]);
//            $rules = new InfiniteIterator(Rule::$currentRuleSet->getIterator());
//            $rules->rewind();

            foreach ($pool->sources()->where('enabled', true)->get() as $source) {
                print("Handling source: {$source->name}\n");

                $mailbox = new Mailbox($source->connection, $source->login, $source->password);
                $mailsIds = $mailbox->searchMailbox('ALL');

//                $rule = $rules->current();
//                $rule = Rule::$currentRuleSet->get()->max('priority');
                $rule = Rule::$currentRuleSet->get()->sortByDesc('priority')->first();

                foreach($mailsIds as $id) {
                    $mail = $mailbox->getMail($id, false);

                    foreach ($pool->filters()->where('enabled', true) as $filter) {
                        switch($this->filterMail($filter, $mail)){
                            case Filter::ACTION_SEND:
                                break;
                            case Filter::ACTION_REJECT:
                                $rule = $pool->defaultRule();
                                break;
                            case Filter::ACTION_NOACTION:
                            default:
                                break;
                        }
                    }
                    print("mail from: {$mail->fromAddress} added using rule: {$rule->name} with priority: {$rule->priority}\n");
                    $rule->increment('counter');

//                    $queue->insert(['mail' => $mail, 'rule' => $rule], $rule->weight);

//                    $rules->next();
//                    $rule = $rules->current();
                }
            }
/*
            print("Priority queue NEW ORDER:\n");
            foreach ($queue as $item){
                print("mail from: {$mail->fromAddress} using rule: {$rule->name} with priority: {$rule->weight}\n");
            }
*/

/*
 *                    print("id: {$mail->id} recieved on {$mail->date}\nFrom: {$mail->fromName} <{$mail->fromAddress}>\nSubj: {$mail->subject}\n\n{$mail->textPlain}\n");
                    if ($mail->textHtml) print("\nHTML:\n\n{$mail->textHtml}\n\n");
                    $att = null;
                    if ($att = $mail->getAttachments()) print_r($att);

                    print_r($mail);
                    if ($id > 2) break;

 */
        }
    }

    public function filterMail($filter, $mail)
    {
        print("Checking mail filter: {$filter->name}\n");
        $ret = (preg_match($filter->regexp, $mail[$filter->mail_field])) ? $filter->action : Filter::ACTION_NOACTION;
        print("Filter action: $ret\n");
        return $ret;
    }
}
