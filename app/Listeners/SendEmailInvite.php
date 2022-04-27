<?php

namespace App\Listeners;

use App\Events\Profiled;
use App\Mail\AccountMail;
use App\Notifications\UserInvitation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailInvite
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
     * @param  \App\Events\Profiled  $event
     * @return void
     */
    public function handle(Profiled $event)
    {
        //Mail::to($event->user->email)->send(new AccountMail($event->user));
        $event->user->notify(new UserInvitation());
    }
}
