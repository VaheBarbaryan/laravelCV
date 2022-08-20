<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    private $user;

    public $body;
    public $fileAttach;
    public $subject;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($body, $fileAttach = null,$subject, $type = null)
    {
        $this->body = $body;
        $this->fileAttach = $fileAttach;
        $this->subject = $subject;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->subject($this->subject)->view('email.message');

//        if ($this->fileAttach) {
//            $message->attach(public_path($this->fileAttach));
//            $message = $this->subject($this->subject)->view('email.message');
//        }

        return $message;
    }
}
