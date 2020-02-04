<?php

namespace App\Http\Controllers\Client;

use Log;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Airlock\Airlock;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Client\Controller;
use App\Http\Requests\EmailIsUniqueRequest;
use App\Http\Requests\PasswordIsValidRequest;
use App\Http\Requests\UsernameIsUniqueRequest;

class AuthController extends Controller
{
    public function user()
    {
        $user = Auth::user();

        return $this->success(new UserResource($user));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Handle a refresh request to the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request)
    {
        $expiration = now()->subMinutes(config('airlock.expiration', 0));
        $expiration_window = $expiration->addMinutes(config('airlock.expiration_window', 0));
        $currentToken = app(Airlock::$personalAccessTokenModel)
            ->where('token', hash('sha256', $request->bearerToken()))
            ->firstOrFail();

        if (
            $currentToken->created_at->gte($expiration)
         || $currentToken->created_at->lte($expiration_window)) {
                $token = $currentToken->tokenable->createToken('default')->plainTextToken;
                $currentToken->delete();
                return $this->success(compact('token'), "Refreshed token");
        }

        // TODO: add error code
        return $this->error([], "Invalid token");
    }

    /**
     * Handle a login request to the application.
     * ['identifier', 'password']
     * Takes UserName Or Email
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->error([], 'Invalid Credentials', 401);
        }

        $token = $user->createToken('default')->plainTextToken;
        $user  = new UserResource($user);

        return $this->success(compact('token', 'user'), "Logged in");
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->user()->tokens->each->delete();

        return $this->success([], "Logged out");
    }

    /***************************************************************************************
     ** VALIDATION
     ***************************************************************************************/

    public function emailIsUnique(EmailIsUniqueRequest $request)
    {
        return $this->success();
    }

    public function passwordIsValid(PasswordIsValidRequest $request)
    {
        return $this->success();
    }

    public function usernameIsUnique(UsernameIsUniqueRequest $request)
    {
        return $this->success();
    }
}
