<?php

namespace App\Services;

use App\Helpers\AdminBase;
use App\Models\Location as LocationModel;
use App\Exceptions\AdminApiException as ApiException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class Location extends AdminBase
{
    public function __construct()
    {
        parent::__construct(LocationModel::class, 'Location');
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
            'facility_id' => 'required|integer',
            'logo' => 'sometimes|required|image',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        if ($validator->passes()) {
            $exiting_location = LocationModel::where('title', $data['title'])
            ->where('facility_id', $data['facility_id'])
            ->where('organization_id', $data['organization_id'])
            ->first();
            if (!$exiting_location) {
                $location = new LocationModel();
                $location->title = $data['title'];
                $location->description = $data['description'];
                $location->organization_id = $data['organization_id'];
                $location->facility_id = $data['facility_id'];
                $location->longitude = $data['longitude'];
                $location->latitude = $data['latitude'];
                if(isset($data['creator_id'])){
                    $location->creator_id = $data['creator_id'];
                } else {
                    $location->creator_id = $data['user']->id;
                }
                if (isset($data['logo'])) {
                    $file = $data['logo'];
                    $path = $file->hashName('locations/logos');
                    $image = Image::make($file);
                    $image->fit(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    if(Storage::disk('public')->put($path, (string) $image->encode())) {
                        $location->logo = $path;
                    }
                }
                if ($location->save()) {
                    return $location;
                }
            } else {
                throw new ApiException("An location with this title is already registered", '405');
            }
        } else {
            throw new ApiException($validator->errors(), '422', $data);
        }
    }


    public function update(array $data)
    {
        $rules = [
            'id' => 'required|integer',
            'description' => 'required|max:255',
            'organization_id' => 'required|integer',
            'facility_id' => 'required|integer',
            'logo' => 'sometimes|required|image',
            'longitude' => 'required',
            'latitude' => 'required'
        ];
        return $this->updateModel($data, $rules);
    }

    public function delete($id, $where = [])
    {
        return $this->deleteModel($id, $where);
    }
}
