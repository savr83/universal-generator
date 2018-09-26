<?php

namespace App\Mail\Mailkit;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Swift_Attachment;

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
        $body = preg_replace('/(\n)/su', '<br />', $this->mail->textPlain);
        $bodyType = "plain";
        if ($html = $this->mail->textHtml) {
            $m = null;
            if (preg_match_all('/<head[^>]*>(.*?)<\/head>/isu', $html, $m)) {
                $head = $m[1][0];
            }
            if (preg_match_all('/<body[^>]*>(.*?)<\/body>/isu', $html, $m)) {
                $body = $m[1][0];
            } else {
                $body = preg_replace('/<html[^>]*>(.*?)<\/html>/isu', '$1', $html);
            }
            $bodyType = "html";
        }
//        print("BODY TYPE IS: $bodyType\n---\nHEAD:\n$head\n---\nBODY:\n$body\n---\n");

        return $this->from($this->fromAddress)
            ->view('MailKit.forwarded')
            ->with([
                "date" => $this->mail->date,
                "from" => $this->mail->fromAddress,
                "subj" => $this->mail->subject,
                "type" => $bodyType,
                "head" => $head,
                "body" => $body
            ])
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()->addTextHeader('From', $this->mail->fromAddress);
                $message->getHeaders()->addTextHeader('Reply-To', $this->mail->fromAddress);
                $message->getHeaders()->addTextHeader('Subject', $this->mail->subject);

                if ($attachments = $this->mail->getAttachments()) {
                    foreach ($attachments as $attachment) {
                        print("got attachment!\n");
                        dump($attachment);
                        $swift_attachment = Swift_Attachment::fromPath($attachment->filePath)->setFilename($attachment->name);
                        $swift_attachment->setDisposition($attachment->disposition ?? "inline");
                        if ($attachment->contentId) {
                            $swift_attachment->getHeaders()->addTextHeader('Content-ID', "<{$attachment->contentId}>");
//                            $swift_attachment->getHeaders()->addTextHeader('X-Attachment-Id', "<{$attachment->contentId}>");
                        }
                        $message->embed($swift_attachment);
                    }
                }

        });
    }
}
