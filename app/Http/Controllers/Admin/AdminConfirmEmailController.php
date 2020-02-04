<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\EmailConfirmation;
use App\Jobs\ResendConfirmationEmail;
use App\Http\Requests\ConfirmEmailRequest;
use App\Http\Controllers\Client\Controller;
use App\Http\Requests\CheckConfirmEmailRequest;
use App\Http\Requests\ConfirmEmailResendRequest;

class AdminConfirmEmailController extends Controller
{
    public function confirm(ConfirmEmailRequest $request)
    {
        $emailConfirmation = EmailConfirmation::with('user')->byToken($request->token)->byEmail($request->email)->first();
        $emailConfirmation->setConfirmed();

        return $this->success();
    }

    public function create(ConfirmEmailResendRequest $request)
    {
        $user = User::byEmail($request->email)->first();
        $emailConfirmation = EmailConfirmation::makeOne($user);

        ResendConfirmationEmail::dispatch($user, $emailConfirmation);

        return $this->success();
    }

    public function checkStatus(CheckConfirmEmailRequest $request)
    {
        $user = User::byEmail($request->email)->first();

        return $this->success(['email_confirmed' => $user->email_confirmed]);
    }
}
