<?php

namespace App\Services;

use App\Helpers\AdminBase;
use App\Models\Page as PageModel;
use App\Exceptions\AdminApiException as ApiException;
use App\Models\Organization;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Page extends AdminBase
{
    public function __construct()
    {
        parent::__construct(PageModel::class, 'Page');
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
            'title' => 'required|max:255'
        ]);
        if ($validator->passes()) {
            $slug = Str::slug($data['title'], '-');
            $existing_page = PageModel::where('slug', $slug)->first();
            if (!$existing_page) {
                $page = new PageModel();
                $page->title = $data['title'];
                $page->slug = $slug;
                $page->content = $data['content'];

                if ($page->save()) {
                    return $page;
                }
            } else {
                throw new ApiException("A page with this slug is already created", '405');
            }
        } else {
            throw new ApiException($validator->errors(), '422', $data);
        }
    }


    public function update(array $data)
    {
        $rules = [
            'id' => 'required|integer',
            'title' => 'required|string|max:255'
        ];
        return $this->updateModel($data, $rules);
    }

    public function delete($id, $where = [])
    {
        return $this->deleteModel($id, $where);
    }
}
