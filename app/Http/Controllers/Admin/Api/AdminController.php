<?php

namespace App\Http\Controllers\Admin\Api;

use App\Exceptions\AdminApiException;
use App\Http\Controllers\ApiController;
use App\Services\Admin;
use App\Models\Admin as AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends ApiController
{

    protected $sAdmin;

    public function __construct(Admin $sAdmin)
    {
        $this->sAdmin = $sAdmin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $options = $this->sAdmin->standardize_search($request);
        $list = $this->sAdmin->find($options);
        if (isset($options['limit']) && $options['limit'] > 0) {
            $this->setPagination($this->sAdmin->get_paginator()->toArray());
        }
        return $this->respondData('Admins list',  $list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = $this->sAdmin->store($request->all());
        if ($admin) {
            return $this->respondData('Admin created',  $admin);
        }
        return $this->respondWithErrors(500, 'Error creating the admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = $id > 0 ? AdminModel::find($id) : AdminModel::find(Auth::user()->id);
        if ($admin) {
            return $this->respondData('Admin',  $admin);
        }
        return $this->respondWithErrors(404, 'Admin not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id > 0 ? $id : Auth::user()->id;
        $admin = $this->sAdmin->update($data);
        if ($admin) {
            return $this->respondData('Admin updated',  $admin);
        } else {
            return $this->respondWithErrors(404, 'Admin not found');
        }
        return $this->respondWithErrors(500, 'Error updating the admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id > 0) {
            $admin = AdminModel::find($id);
            if ($admin) {
                if ($admin->delete()) {
                    return $this->respondData('Admin deleted',  $admin);
                } else {
                    return $this->respondWithErrors(500, 'Error deleting the admin');
                }
            }
        }
        return $this->respondWithErrors(404, 'Admin not found');
    }

    public function changePassword(Request $request)
    {
        try{
            $admin = $this->sAdmin->changePassword($request->all());
            if ($admin) {
                return $this->respondData("Password changed successfully", $admin);
            }
            return $this->respondWithErrors(500, 'Error updating password');
            
        } catch(AdminApiException $e){
            return $this->respondWithErrors(422, $e->messages());
        }
    }

    public function removeAvatar($id)
    {
        $admin = AdminModel::find($id);
        if ($admin) {
            if($admin->avatar != ''){
                if(Storage::disk('public')->delete($admin->avatar)){
                    $admin->avatar = null;
                    if($admin->save()){
                        return $this->respondData("Avatar removed successfully", $admin);
                    } else {
                        return $this->respondWithErrors(500, 'Error removing the avatar');
                    }
                } else {
                    return $this->respondWithErrors(500, 'Error removing avatar file');
                }
            } else {
                return $this->respondWithErrors(422, 'Avatar not found');
            }
        }
        return $this->respondWithErrors(404, 'Admin not found');
    }
}
