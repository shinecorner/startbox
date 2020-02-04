<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\EmailConfirmation;

class ConfirmationEmail extends Mailable
{
    use Queueable;

    public $user;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, EmailConfirmation $emailConfirmation)
    {
        $this->user = $user;
        $this->url = $this->getConfirmEmailLink($emailConfirmation);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.user.confirmation')->subject('Confirm your email address');
    }

    public function getConfirmEmailLink(EmailConfirmation $emailConfirmation)
    {
        return env('WEB_APP_URL') . '/confirm-email?email=' . urlencode($emailConfirmation->email) . '&token=' . $emailConfirmation->token;
    }
}
