<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\JsonFormRequest;
use App\Rules\PasswordMatchesRule;
use Auth;

class UpdateUserRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->id == $this->route('user')->id) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'string|min:2',
            'last_name' => 'string|min:2',
            'email' => 'string|email|unique:users,email,' . Auth::user()->id,
            'password' => [
                'min:6',
                new PasswordMatchesRule,
                //'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', (atleast one symbol) // /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/    --> one upper, one lower, and one number
            ],
            'new_password' => [
                'required_with:password',
                'min:6',
                'confirmed',
                //'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', (atleast one symbol) // /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/    --> one upper, one lower, and one number
            ],
            'picture' => 'image',
            'is_update' => 'required|boolean',
        ];
    }

    /***************************************************************************************
     ** Overriding
     ***************************************************************************************/

    /**
     * Append "is_update" to Request Input before validation
     */
    public function addIsUpdate()
    {
        $data = $this->all();
        $data['is_update'] = (bool) ($this->method() == 'PUT');
        $this->replace($data);
        return $this->all();
    }

    /**
     * Modify Input Data Before Validation
     */
    public function validateResolved()
    {
        $this->addIsUpdate();
        parent::validateResolved();
    }
}