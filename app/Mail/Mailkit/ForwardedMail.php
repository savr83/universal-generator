<?php

namespace App\Mail\Mailkit;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Swift_Attachment;
use Swift_Message;

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
    public function __construct($login, $password, $mail = null)
    {
        $this->fromAddress = $login;
        $this->mail = $mail;
        config()->set([
            'mail.username' => $login,
            'mail.password' => $password
        ]);
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
        $charset = '';
        $bodyType = "plain";
        if ($html = $this->mail->textHtml) {
            $m = null;
            if (preg_match_all('/<head[^>]*>(.*?)<\/head>/isu', $html, $m)) {
                $head = $m[1][0];
                if (preg_match_all('/<meta.*?charset=([^"\']+)/', $html, $mc)) $charset = $mc[1][0];
            }
            if (preg_match_all('/<body[^>]*>(.*?)<\/body>/isu', $html, $m)) {
                $body = $m[1][0];
            } else {
                $body = preg_replace('/<html[^>]*>(.*?)<\/html>/isu', '$1', $html);
            }
            $bodyType = "html";
        }
        return $this->from($this->fromAddress, ($this->mail->fromName ? $this->mail->fromName : $this->mail->fromAddress))
            ->view('MailKit.forwarded')
            ->with([
                "date" => $this->mail->date,
                "from" => $this->mail->fromAddress,
                "subj" => $this->mail->subject,
                "charset" => $charset,
                "type" => $bodyType,
                "head" => $head,
                "body" => $body
            ])
            ->withSwiftMessage(function (Swift_Message $message) use ($charset) {
//                $message->setFrom($this->fromAddress, ($this->mail->fromName ? $this->mail->fromName : $this->mail->fromAddress));
                $message->setReplyTo($this->mail->fromAddress, ($this->mail->fromName ? $this->mail->fromName : $this->mail->fromAddress));
                $message->setSubject($this->mail->headers->subject);
//                if ($charset) $message->setCharset($charset);

                if ($attachments = $this->mail->getAttachments()) {
                    foreach ($attachments as $attachment) {
                        print("got attachment!\n");
                        dump($attachment);
                        $swift_attachment = Swift_Attachment::fromPath($attachment->filePath)->setFilename($attachment->name);
                        $swift_attachment->setDisposition($attachment->disposition ?? "inline");
                        if ($attachment->contentId) {
                            $swift_attachment->getHeaders()->addIdHeader('Content-ID', $attachment->contentId);
                        }
                        $message->embed($swift_attachment);
                    }
                }

        });
    }
}
