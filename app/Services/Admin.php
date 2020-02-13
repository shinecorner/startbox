<?php

namespace App\Services;

use App\Helpers\AdminBase;
use App\Models\Admin as AdminModel;
use App\Exceptions\AdminApiException as ApiException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Admin extends AdminBase
{
    public function __construct()
    {
        parent::__construct(AdminModel::class, 'Admin');
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'avatar' => 'sometimes|required|image'
        ]);
        if ($validator->passes()) {
            $exiting_admin = AdminModel::where('email', $data['email'])->first();
            if (!$exiting_admin) {
                $admin = new AdminModel();
                $admin->first_name = $data['first_name'];
                $admin->last_name = $data['last_name'];
                $admin->email = $data['email'];
                $admin->password = isset($data['password']) ? bcrypt($data['password']) : bcrypt(Str::random(15));
                $admin->status = $data['active'];
                if (isset($data['avatar'])) {
                    $file = $data['avatar'];
                    $path = $file->hashName('admins/avatars');
                    $image = Image::make($file);
                    $image->fit(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    if(Storage::disk('public')->put($path, (string) $image->encode())) {
                        $admin->avatar = $path;
                    }
                }
                if ($admin->save()) {
                    return $admin;
                }
            } else {
                throw new ApiException("An admin with this email address is already registered", '405');
            }
        } else {
            throw new ApiException($validator->errors(), '422', $data);
        }
    }


    public function update(array $data)
    {
        $rules = [
            'id' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'avatar' => 'sometimes|required|image'
        ];
        $admin = $this->updateModel($data, $rules);
        if($admin){
            if(isset($data['avatar'])){
                $current = $admin->avatar;
                $file = $data['avatar'];
                $path = $file->hashName('admins/avatars');
                $image = Image::make($data['avatar']);
                $image->fit(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if(Storage::disk('public')->put($path, (string) $image->encode())) {
                    $admin->avatar = $path;
                }
                if($current != ''){
                    Storage::disk('public')->delete($current);
                }
            }
            if($admin->save()){
                return $admin;
            }
        } 
        throw new ApiException("Error updating admin data", '500');
    }

    public function delete($id, $where = [])
    {
        return $this->deleteModel($id, $where);
    }
}
