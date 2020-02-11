<?php

namespace App\Jobs;

use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordEmailAdmin;
use Log;

class SendResetPasswordEmailAdmin implements ShouldQueue
{
    use Dispatchable;

    public $user;
    public $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Admin $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $success = Mail::to($this->user->email)->send(new ResetPasswordEmailAdmin($this->user, $this->token));
    }
}
