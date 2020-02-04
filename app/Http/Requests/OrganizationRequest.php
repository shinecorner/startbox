<?php

namespace App\Http\Requests;

use App\Models\Organization;
use App\Http\Requests\JsonFormRequest;
use Illuminate\Contracts\Validation\Validator;

class OrganizationRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->checkAuthorization(Organization::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'title' => 'required_if:is_post,true|string|min:2',
			'description' => 'required_if:is_post,true|string|min:2',
		];
    }
}