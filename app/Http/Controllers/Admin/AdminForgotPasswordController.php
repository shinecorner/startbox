<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Jobs\SendResetPasswordEmailAdmin;
use App\Models\Admin;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class AdminForgotPasswordController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $user = Admin::byEmail($request->email)->first();

        if($user){
            $token = $this->broker()->createToken($user);
            if ($token) {
                dispatch(new SendResetPasswordEmailAdmin($user, $token));

                return $this->respondData('Sent reset password link!');
            }
        }
        return $this->respondWithErrors('422', 'Fail sending reset password link', []);
    }
}
