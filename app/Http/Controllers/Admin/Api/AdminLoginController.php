<?php
namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Token;

class AdminLoginController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->respondWithErrors('422', $validator->errors());
        }

        $user = Admin::where('email',  $data['email'])->first();

        if (!$user || ! Hash::check($data['password'], $user->password)) {
            return $this->respondWithErrors('403', ['Invalid credentials']);
        }

        return $this->allowLogin($user, $request, '');        
    }



    public function allowLogin($user, $request, $scopes)
    {
        if (is_string($scopes)) {
            $scopes = explode(',', $scopes);
        }
        $token_data = $user->createToken($user->first_name . ' ' . $user->last_name, $scopes);
        $res = [
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'avatar' => $user->avatar
            ],
            'auth' => [
                'access_token' => $token_data->plainTextToken,
            ]
        ];
        
        return $this->respondData('Done!', $res);
    }

    public function logout(Request $request)
    {
        if (Auth::user()->currentAccessToken()->delete()) {
            return $this->respondData('Closed session', []);
        }
        return $this->respondWithErrors('422', ['Invalid Query Format.']);        
    }
}
