<?php

namespace App\Http\Requests;

use App\Models\Nogo;
use App\Http\Requests\JsonFormRequest;
use Illuminate\Contracts\Validation\Validator;

class NogoRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->checkAuthorization(Nogo::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'organization_id' => 'required_if:is_post,true|integer|exists:organizations,id',
			'facility_id' => 'required_if:is_post,true|integer|exists:facilities,id',
			'creator_id' => 'required_if:is_post,true|integer|exists:creators,id',
			'provider_id' => 'required_if:is_post,true|integer|exists:providers,id',
			'patient_id' => 'required_if:is_post,true|integer|exists:patients,id',
			'procedure_id' => 'required_if:is_post,true|integer|exists:procedures,id',
			'title' => 'required_if:is_post,true|string|min:2',
            'description' => 'required_if:is_post,true|string|min:2',
            'status' => 'required_if:is_post,true|string|min:2',
		];
    }
}