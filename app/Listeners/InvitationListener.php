<?php

namespace App\Listeners;

use App\Mail\InvitationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class InvitationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        foreach ($event->event->visitors as $visitor){
            Mail::to($visitor->user['email'])->send(new InvitationEmail($visitor, $event->event));
        }
    }
}
