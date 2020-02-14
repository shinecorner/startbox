<?php

namespace App\Services;

use App\Helpers\AdminBase;
use App\Models\Admin as AdminModel;
use App\Exceptions\AdminApiException as ApiException;
use Illuminate\Support\Facades\Hash;
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
        $avatar = null;
        if(isset($data['avatar'])){
            $avatar = $data['avatar'];
            unset($data['avatar']);
        }
        $admin = $this->updateModel($data, $rules);
        if($admin){
            if($avatar){
                $current = $admin->avatar;
                $path = $avatar->hashName('admins/avatars');
                $image = Image::make($avatar);
                $image->fit(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if(Storage::disk('public')->put($path, (string) $image->encode()) == 1){
                    if($current != ''){
                        Storage::disk('public')->delete($current);
                    }
                    $admin->avatar = $path;
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

    public function changePassword($data)
    {
        $messages = [
            'password.regex' => 'Password length should be between 8 to 16 characters and contains at least: a digit, a lower case letter, an upper case letter and an special character (other than letters and numbers)',
            'password.confirmed' => 'Password and password confirmation do not match'
        ];
        $validator = Validator::make($data, [
            'id' => 'required',
            'current_password' => 'required|max:255',
            'password' => 'required|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,10}\S+$/'
        ], $messages);
        if ($validator->passes()) {
            $admin = AdminModel::find($data['id']);
            if ($admin) {
                if (Hash::check($data['current_password'], $admin->password)) {
                    $admin->password = bcrypt($data['password']);
                    if ($admin->save()) {
                        return $admin;
                    }
                } else {
                    throw new ApiException('Invalid current password', '422', []);
                }
            }
        } else {
            throw new ApiException($validator->errors(), '422', $data);
        }
    }
}
