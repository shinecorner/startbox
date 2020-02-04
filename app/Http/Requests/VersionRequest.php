<?php

namespace App\Http\Requests;

use App\Models\Version;
use App\Http\Requests\JsonFormRequest;
use Illuminate\Contracts\Validation\Validator;

class VersionRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->checkAuthorization(Version::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'creator_id' => 'required_if:is_post,true|integer|exists:creators,id',
			'title' => 'required_if:is_post,true|string|min:2',
			'description' => 'required_if:is_post,true|string|min:2',
            'severity' => 'required_if:is_post,true|string|min:2',
            'build' => 'required_if:is_post,true|string|min:2',
            'major' => 'required_if:is_post,true|integer',
            'minor' => 'required_if:is_post,true|integer',
            'patch' => 'required_if:is_post,true|integer',
		];
    }
}