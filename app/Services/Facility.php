<?php

namespace App\Services;

use App\Helpers\AdminBase;
use App\Models\Facility as FacilityModel;
use App\Exceptions\AdminApiException as ApiException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class Facility extends AdminBase
{
    public function __construct()
    {
        parent::__construct(FacilityModel::class, 'Facility');
    }

    public function init_fillable()
    {
        foreach ($this->model->getFillable() as $key) {
            $this->fillable[$key] = '';
        }
    }

    public function store(array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'organization_id' => 'required|integer',
            'logo' => 'sometimes|required|image',
            'user' => 'required'
        ]);
        if ($validator->passes()) {
            $exiting_facility = FacilityModel::where('title', $data['title'])->first();
            if (!$exiting_facility) {
                $facility = new FacilityModel();
                $facility->title = $data['title'];
                $facility->description = $data['description'];
                $facility->organization_id = $data['organization_id'];
                $facility->timezone = 'America/New_York';
                if(isset($data['creator_id'])){
                    $facility->creator_id = $data['creator_id'];
                } else {
                    $facility->creator_id = $data['user']->id;
                }
                if (isset($data['logo'])) {
                    $file = $data['logo'];
                    $path = $file->hashName('facilities/logos');
                    $image = Image::make($file);
                    $image->fit(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    if(Storage::disk('public')->put($path, (string) $image->encode())) {
                        $facility->logo = $path;
                    }
                }
                if ($facility->save()) {
                    return $facility;
                }
            } else {
                throw new ApiException("An facility with this title is already registered", '405');
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
            'description' => 'required|string',
            'organization_id' => 'required|integer'
        ];
        return $this->updateModel($data, $rules);
    }

    public function delete($id, $where = [])
    {
        return $this->deleteModel($id, $where);
    }
}
