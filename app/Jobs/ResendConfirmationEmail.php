<?php

namespace App\Jobs;

use App\Mail\ConfirmationEmail;
use App\Models\EmailConfirmation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class ResendConfirmationEmail implements ShouldQueue
{
    use Dispatchable;

    public $user;
    public $emailConfirmation;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, EmailConfirmation $emailConfirmation)
    {
        $this->user = $user;
        $this->emailConfirmation = $emailConfirmation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new ConfirmationEmail($this->user, $this->emailConfirmation));
    }
}
