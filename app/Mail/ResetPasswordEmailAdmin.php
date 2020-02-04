<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordEmailAdmin extends Mailable
{
    use Queueable;

    public $user;
    public $token;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->url = $this->getUrl();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mail.password_reset')->subject('Reset your password');
    }

    public function getUrl()
    {
        return env('APP_URL') . '/admin/password/reset?email=' . $this->user->email . '&token=' . $this->token;
    }
}
