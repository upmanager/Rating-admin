<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $text, $attaches)
    {
        $this->subject = $subject;
        $this->text = $text;
        $this->attaches = $attaches;
        if ($attaches == null || $attaches == "") {
            $this->attaches = [];
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from(env('MAIL_USERNAME', ''))
            ->replyTo(env('MAIL_USERNAME', ''))
            ->subject($this->subject)
            ->html($this->text)
            ->view('sendmail', []);
        foreach ($this->attaches as $value) {
            $email->attach($value);
        }
        return $email;
    }
}
