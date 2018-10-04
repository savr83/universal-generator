<?php

namespace App\Console\Commands;

use App\Mailkit\Log;
use App\Mailkit\Pool;
use App\Mailkit\Rule;
use App\Mailkit\Source;
use Illuminate\Console\Command;

class MailkitTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailkit:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dev test';

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
     * @return mixed
     */
    public function handle()
    {
        print('running test\n');

        if ($existingLog = Log::where(['pool_name' => 'Main', 'from' => 'stroitorg35@bk.ru'])->sortByDesc('updated_at')->first()) {
            print('Found existing rule!!!\n');
            dump($existingLog->rule());
        }

/*
        $pool = new Pool();
        $source = new Source();
        $rule = new Rule();

        $pool->name = "Main pool";
        $pool->description = "Main and single pool for getting e-mails";

        $source->name = "Beget mail";
        $source->connection = '{imap.beget.com:143/imap}INBOX';
        $source->login = 'zakaz-rostov@agregat.me';
        $source->password = 'NsOxD5v%';

        $rule->name = "Test rule";
        $rule->recipient_list = "mail-rostov@agregat.me";

        $pool->sources()->save($source);
        $pool->rules()->save($rule);
        $pool->save();
*/
    }
}
