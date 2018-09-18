<?php

namespace App\Mail\Mailkit;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForwardedMail extends Mailable
{
    use Queueable, SerializesModels;


    private $fromAddress;
    private $mail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($from = "email@site.com", $mail = null)
    {
        $this->fromAddress = $from;
        $this->mail = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("zakaz-rostov@agregat.me")
            ->view('MailKit.forwarded')
            ->with([
                "id" => $this->mail->id,
                "date" => $this->mail->date,
                "from" => $this->mail->fromAddress,
                "subj" => $this->mail->subject,
                "textPlain" => $this->mail->textPlain,
                "textHtml" => $this->mail->textHtml
            ])
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()->addTextHeader('From', $this->fromAddress);
                $message->getHeaders()->addTextHeader('Reply-To', $this->fromAddress);
                $message->getHeaders()->addTextHeader('Subject', $this->mail->subject);
        });
    }
}
