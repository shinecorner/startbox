<?php

namespace App\Listeners;

use App\Events\NewUserSignedUp;
use App\Mail\ConfirmationEmail;
use App\Models\EmailConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendConfirmationEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  NewBankAccountAdded  $event
     * @return void
     */
    public function handle(NewUserSignedUp $event)
    {
        // 1. create confirm_email_request
        $confirm_request = EmailConfirmation::makeOne($event->user);

        // 2. Dispatch Email
        Mail::to($event->user->email)->send(new ConfirmationEmail($event->user, $confirm_request));
    }
}
