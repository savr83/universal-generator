<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
     * @return mixed
     */
    public function handle()
    {
/*
smtp.beget.com:25 | 2525
:465
pop3.beget.com:110
:995
imap.beget.com:143
:993

zakaz-rostov:NsOxD5v%
mail-rostov:m6BsmnF%
motor-rostov:u97qj&MV

!!! Beget limits !!!
mail() (sendmail) 30 emails per minute
SMTP 30 emails per minute + 1500 per hour
recipients max: 300
message size max: 100Mb for SMTP, 70Mb for sendmail
*/
        print("Get emails using IMAP...\n");
//        $mailbox = new Mailbox('{imap.beget.com:143/imap/ssl}INBOX', 'zakaz-rostov', 'NsOxD5v%', __DIR__);

// 4 secure connection:
//        $mailbox = new Mailbox('{imap.beget.com:993/imap/ssl}INBOX', 'zakaz-rostov@agregat.me', 'NsOxD5v%');

        $mailbox = new Mailbox('{imap.beget.com:143/imap}INBOX', 'zakaz-rostov@agregat.me', 'NsOxD5v%');
        $mailsIds = $mailbox->searchMailbox('ALL');
        if(!$mailsIds) {
            die('Mailbox is empty');
        }

        print_r($mailsIds);

        foreach($mailsIds as $id) {
            $mail = $mailbox->getMail($id, false);

            print("id: {$mail->id} recieved on {$mail->date}\nFrom: {$mail->fromName} <{$mail->fromAddress}>\nSubj: {$mail->subject}\n\n{$mail->textPlain}\n");
            if ($mail->textHtml) print("\nHTML:\n\n{$mail->textHtml}\n\n");
            $att = null;
            if ($att = $mail->getAttachments()) print_r($att);

            print_r($mail);
            if ($id > 2) break;
        }
    }
}
