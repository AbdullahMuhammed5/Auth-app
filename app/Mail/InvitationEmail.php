<?php

namespace App\Mail;

use App\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Visitor
     */
    public $visitor;

    /**
     * Create a new message instance.
     *
     * @param Visitor $visitor
     */
    public function __construct($visitor)
    {
        $this->visitor = $visitor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $visitor = $this->visitor;
        return $this->markdown('emails.invitation', compact('visitor'));
    }
}
