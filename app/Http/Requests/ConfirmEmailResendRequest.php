<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\JsonFormRequest;
use App\Models\User;
use App\Models\EmailConfirmation;
use Auth;
use Carbon\Carbon;

class ConfirmEmailResendRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }

    /***************************************************************************************
     ** Overriding
     ***************************************************************************************/

    /**
     * Modify Conditions of Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        // $validator->sometimes();
        $validator->after(function ($validator) {
            // 1. check user
            $user = User::byEmail($this->input('email'))->first();
            if ($user->email_confirmed) {
                $validator->errors()->add('email', 'The email address was already confirmed.');
            }

            // 2. check request not already sent
            if (EmailConfirmation::where('email', $this->input('email'))->where('created_at', '>=', Carbon::now()->subMinutes(1))->exists()) {
                $validator->errors()->add('email', 'Please wait at least 1 minute before requesting another email.');
            }
        });
        return $validator;
    }
}