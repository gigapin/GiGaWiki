<?php

namespace App\Listeners;

use App\Events\UserAdded;
use App\Mail\EmailConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailConfirmation
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
     * @param  \App\Events\UserAdded  $event
     * @return void
     */
    public function handle(UserAdded $event)
    {
        Mail::to($event->user->email)->send(new EmailConfirmation($event->user));
    }
}
