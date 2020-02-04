<?php

namespace App\Http\Requests;

use App\Models\Procedure;
use App\Http\Requests\JsonFormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProcedureRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->checkAuthorization(Procedure::class);
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
			'patient_id' => 'required_if:is_post,true|integer|exists:patients,id',
			'provider_id' => 'required_if:is_post,true|integer|exists:providers,id',
			'template_id' => 'required_if:is_post,true|integer|exists:templates,id',
			'title' => 'required_if:is_post,true|string|min:2',
			'description' => 'required_if:is_post,true|string|min:2',
			'laterality' => 'required_if:is_post,true|string|min:2',
		];
    }
}