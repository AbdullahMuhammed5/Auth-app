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
    public $event;

    /**
     * Create a new message instance.
     *
     * @param Visitor $visitor
     * @param $event
     */
    public function __construct($visitor, $event)
    {
        $this->visitor = $visitor;
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $visitor = $this->visitor;
        $event = $this->event;
        return $this->markdown('emails.invitation', compact('visitor', 'event'));
    }
}
