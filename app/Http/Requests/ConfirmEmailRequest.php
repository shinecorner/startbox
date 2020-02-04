<?php

namespace App\Http\Requests;

use Auth;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\EmailConfirmation;
use App\Http\Requests\JsonFormRequest;
use Illuminate\Contracts\Validation\Validator;

class ConfirmEmailRequest extends JsonFormRequest
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
            'token' => [
                'required',
                'string',
                Rule::exists('email_confirmations', 'token')->where(function($query) {
                    $query->where('email', $this->email);
                }),
            ],
            'email' => 'required|email|exists:users,email',
        ];
    }

    /***************************************************************************************
     ** Overriding
     ***************************************************************************************/

    public function messages()
    {
        return [
            'token.exists' => 'This request is invalid.',
            'email.exists'  => 'This request is invalid.',
        ];
    }

    /**
     * Modify Conditions of Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        // $validator->sometimes();
        $validator->after(function ($validator) {
            // 1. make sure the request wasn't already used
            if (EmailConfirmation::byToken($this->input('token'))->confirmed()->exists()) {
                $validator->errors()->add('token', 'The email address was already confirmed.');
            }

            // 2. make sure the user didn't already confirm with another request
            $user = User::byEmail($this->input('email'))->first();
            if ($user->email_confirmed) {
                $validator->errors()->add('email', 'The email address was already confirmed.');
            }
        });
        return $validator;
    }
}