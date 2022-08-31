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
    public function __construct($login, $mail = null)
    {
        $this->fromAddress = $login;
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
            ->view('mailkit.forwarded')
            ->with([
                "date" => $this->mail->date,
                "from" => $this->mail->fromAddress,
                "subj" => $this->mail->subject ?? '',
                "charset" => $charset,
                "type" => $bodyType,
                "head" => $head,
                "body" => $body
            ])
            ->withSwiftMessage(function (Swift_Message $message) use ($charset) {
                $message->setReplyTo($this->mail->fromAddress, ($this->mail->fromName ? $this->mail->fromName : $this->mail->fromAddress));
                $message->setSubject($this->mail->headers->subject ?? '');
                /**
                 *  ks_c_5601-1987 is not supported by mb_convert_encoding()
                 */
//                if ($charset) $message->setCharset($charset);

                if ($attachments = $this->mail->getAttachments()) {
                    foreach ($attachments as $attachment) {
                        print("got attachment!\n");
                        dump($attachment);
                        $swift_attachment = Swift_Attachment::fromPath($attachment->filePath)->setFilename($attachment->name);
                        $swift_attachment->setDisposition($attachment->disposition ?? "inline");
                        if ($contentId = $attachment->contentId) {
                            /**
                             * Swiftmail rejects illegal Content-ID according to:
                             * http://www.faqs.org/rfcs/rfc2111.html and http://www.faqs.org/rfcs/rfc822.html
                             */
                            if (!strpos($contentId, '@')) $contentId .= "@agregat.me";
                            $swift_attachment->setId($contentId);
                        }
                        $message->embed($swift_attachment);
                    }
                }

        });
    }
}
