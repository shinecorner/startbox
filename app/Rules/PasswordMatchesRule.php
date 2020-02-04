<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Auth;
use Hash;

class PasswordMatchesRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $hashed_password = Auth::user()->password;
        if (Hash::check($value, $hashed_password)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your password does not match the current password.';
    }
}
