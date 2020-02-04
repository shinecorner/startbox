<?php

namespace App\Listeners;

use App\Events\NewUserSignedUp;
use App\Events\EmailConfirmed;
use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
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
     * @param  NewBankAccountAdded  $event
     * @return void
     */
    public function handle(EmailConfirmed $event)
    {
        $success = Mail::to($event->user->email)->send(new WelcomeEmail($event->user));
    }
}
