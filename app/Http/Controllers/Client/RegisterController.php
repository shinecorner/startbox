<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Events\NewUserSignedUp;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Client\Controller;

class RegisterController extends Controller
{
    public function newUser(RegisterRequest $request)
    {
        $user = User::makeOne($request->validated());

        event(new NewUserSignedUp($user));

        $token = $user->createToken('default')->plainTextToken;
        $user = new UserResource($user);

        return $this->success(compact('token', 'user'));
    }
}
