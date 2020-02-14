<?php

namespace App\Services;

use App\Helpers\AdminBase;
use App\Models\User as UserModel;
use App\Exceptions\AdminApiException as ApiException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class User extends AdminBase
{
    public function __construct()
    {
        parent::__construct(UserModel::class, 'User');
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
            'organization_id' => 'required|integer',
            'picture' => 'sometimes|required|image'
        ]);
        if ($validator->passes()) {
            $exiting_user = UserModel::where('email', $data['email'])->first();
            if (!$exiting_user) {
                $user = new UserModel();
                $user->first_name = $data['first_name'];
                $user->last_name = $data['last_name'];
                $user->full_name = $data['first_name'].' '.$data['last_name'];
                $user->email = $data['email'];
                $user->organization_id = $data['organization_id'];
                $user->sso_id = Str::random(20);
                $user->token = Str::random(20);
                $user->password = isset($data['password']) ? bcrypt($data['password']) : bcrypt(Str::random(15));
                
                if (isset($data['picture'])) {
                    $file = $data['picture'];
                    $path = $file->hashName('users/pictures');
                    $image = Image::make($file);
                    $image->fit(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    if(Storage::disk('public')->put($path, (string) $image->encode())) {
                        $user->picture = $path;
                    }
                }
                if ($user->save()) {
                    return $user;
                }
            } else {
                throw new ApiException("An user with this email address is already registered", '405');
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
            'organization_id' => 'required|integer',
            'email' => 'required|email|max:255',
            'picture' => 'sometimes|required|image'
        ];
        $picture = null;
        if(isset($data['picture'])){
            $picture = $data['picture'];
            unset($data['picture']);
        }
        $user = $this->updateModel($data, $rules);
        if($user){
            if($picture){
                $current = $user->picture;
                $path = $picture->hashName('users/pictures');
                $image = Image::make($picture);
                $image->fit(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if(Storage::disk('public')->put($path, (string) $image->encode()) == 1){
                    if($current != ''){
                        Storage::disk('public')->delete($current);
                    }
                    $user->picture = $path;
                }
            }
            if($user->save()){
                return $user;
            }
        } 
        throw new ApiException("Error updating user data", '500');
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
            'old_password' => 'required|max:255',
            'password' => 'required|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,10}\S+$/'
        ], $messages);
        if ($validator->passes()) {
            $user = User::find($data['id']);
            if ($user) {
                if (Hash::check($data['old_password'], $user->password)) {
                    $user->password = bcrypt($data['password']);
                    if ($user->save()) {
                        return $user;
                    }
                } else {
                    throw new ApiException('Invalid current password', '004', []);
                }
            }
        } else {
            throw new ApiException($validator->errors(), '004', $data);
        }
    }
}
