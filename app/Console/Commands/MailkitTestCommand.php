<?php

namespace App\Console\Commands;

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
    }
}
