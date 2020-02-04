<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\ApiController;
use App\MockRepository\ProcedureMock;
use App\Services\User;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{

    protected $sUser;

    public function __construct(User $sUser)
    {
        $this->sUser = $sUser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $options = $this->sUser->standardize_search($request);
        $list = $this->sUser->find($options);
        if (isset($options['limit']) && $options['limit'] > 0) {
            $this->setPagination($this->sUser->get_paginator()->toArray());
        }
        return $this->respondData('Users list',  $list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->sUser->store($request->all());
        if ($user) {
            return $this->respondData('User created',  $user);
        }
        return $this->respondWithErrors(500, 'Error creating the user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id > 0) {
            $user = UserModel::find($id);
            if ($user) {
                return $this->respondData('User',  $user);
            }
        }
        return $this->respondWithErrors(404, 'User not found');
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
        if ($id > 0) {
            $user = $this->sUser->update($request->all());
            if ($user) {
                return $this->respondData('User updated',  $user);
            }
            return $this->respondWithErrors(500, 'Error updating the user');
        }
        return $this->respondWithErrors(404, 'User not found');
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
            $user = UserModel::find($id);
            if ($user) {
                if ($user->delete()) {
                    return $this->respondData('User deleted',  $user);
                } else {
                    return $this->respondWithErrors(500, 'Error deleting the user');
                }
            }
        }
        return $this->respondWithErrors(404, 'User not found');
    }

    //Non resources methods
    public function get_user_roles($id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['id' => $id]);
    }

    public function get_user_permissions($id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['id' => $id]);
    }

    public function assign_role($id, $role_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['id' => $id, 'role_id' => $role_id]);
    }

    public function assign_permission($id, $permission_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['id' => $id, 'permission_id' => $permission_id]);
    }

    public function remove_role($id, $role_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['id' => $id, 'role_id' => $role_id]);
    }

    public function remove_permission($id, $permission_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['id' => $id, 'permission_id' => $permission_id]);
    }
}
