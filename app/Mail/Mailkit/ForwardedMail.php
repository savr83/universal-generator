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
        $head = '';
        $body = preg_replace('#(\n)#u', '<br />', $this->mail->textPlain);
        $bodyType = "plain";
        if ($this->mail->textHtml) {
            $head = preg_replace('#<head[^>]*?>(.*)</head>#iu', '$1', $this->mail->textHtml);
            $body = preg_replace('#<body[^>]*?>(.*)</body>#iu', '$1', $this->mail->textHtml);
            $bodyType = "html";
        }
        print("BODY TYPE IS: $bodyType\n---\nHEAD:\n$head\n---\nBODY:\n$body\n---\n");
        return $this->from($this->fromAddress)
            ->view('MailKit.forwarded')
            ->with([
//                "id" => $this->mail->id,
                "date" => $this->mail->date,
                "from" => $this->mail->fromAddress,
                "subj" => $this->mail->subject,
                "head" => $head,
                "body" => $body
            ])
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()->addTextHeader('From', $this->mail->fromAddress);
                $message->getHeaders()->addTextHeader('Reply-To', $this->mail->fromAddress);
                $message->getHeaders()->addTextHeader('Subject', $this->mail->subject);
        });
    }
}
