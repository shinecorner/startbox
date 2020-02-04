<?php

namespace App\Http\Requests;

use App\Models\Patient;
use App\Http\Requests\JsonFormRequest;
use Illuminate\Contracts\Validation\Validator;

class PatientRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->checkAuthorization(Patient::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'dod_identifier' => 'string',
			'first_name' => 'required_if:is_post,true|string|min:2',
			'last_name' => 'required_if:is_post,true|string|min:2',
			'sex' => 'required_if:is_post,true|string|in:m,f,o',
			'dob' => 'required_if:is_post,true|date_format:Y-m-d',
		];
    }
}