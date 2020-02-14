<?php

namespace App\Services;

use App\Helpers\AdminBase;
use App\Models\Organization as OrganizationModel;
use App\Exceptions\AdminApiException as ApiException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class Organization extends AdminBase
{
    public function __construct()
    {
        parent::__construct(OrganizationModel::class, 'Organization');
    }

    public function init_fillable()
    {
        foreach ($this->model->getFillable() as $key) {
            $this->fillable[$key] = '';
        }
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'logo' => 'sometimes|image'
        ]);
        if ($validator->passes()) {
            $exiting_organization = OrganizationModel::where('title', $data['title'])->first();
            if (!$exiting_organization) {
                $organization = new OrganizationModel();
                $organization->title = $data['title'];
                $organization->description = $data['description'];
                if (isset($data['logo'])) {
                    $file = $data['logo'];
                    $path = $file->hashName('organizations/logos');
                    $image = Image::make($file);
                    $image->fit(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    if(Storage::disk('public')->put($path, (string) $image->encode())) {
                        $organization->logo = $path;
                    }
                }
                if ($organization->save()) {
                    return $organization;
                }
            } else {
                throw new ApiException("An organization with this title is already registered", '405');
            }
        } else {
            throw new ApiException($validator->errors(), '422', $data);
        }
    }

    public function update(array $data)
    {
        $rules = [
            'id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ];
        return $this->updateModel($data, $rules);
    }

    public function delete($id, $where = [])
    {
        return $this->deleteModel($id, $where);
    }
}
