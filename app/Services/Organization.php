<?php

namespace App\Services;

use App\Helpers\AdminBase;
use App\Models\Organization as OrganizationModel;
use App\Exceptions\AdminApiException as ApiException;

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
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ];

        $existing = OrganizationModel::where('title', $data['title'])->first();
        if ($existing) {
            throw new ApiException("An organization with title " . $data['title'] . "  already exists.", '422', $data);
        }
        return $this->createModel($data, $rules);
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
