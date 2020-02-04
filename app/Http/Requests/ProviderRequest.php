<?php

namespace App\Http\Requests;

use App\Models\Provider;
use App\Http\Requests\JsonFormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProviderRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->checkAuthorization(Provider::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'first_name' => 'required_if:is_post,true|string|min:2',
			'last_name' => 'required_if:is_post,true|string|min:2',
			'suffix_type' => 'required_if:is_post,true|string|in:md,phd,md-phd,pa,rn,np',
		];
    }
}