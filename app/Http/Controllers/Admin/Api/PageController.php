<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\ApiController;
use App\MockRepository\ProcedureMock;
use App\Services\Page;
use App\Models\Page as PageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends ApiController
{
    protected $sPage;

    public function __construct(Page $sPage)
    {
        $this->sPage = $sPage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $options = $this->sPage->standardize_search($request);
        $list = $this->sPage->find($options);
        if (isset($options['limit']) && $options['limit'] > 0) {
            $this->setPagination($this->sPage->get_paginator()->toArray());
        }
        return $this->respondData('Pages list',  $list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = $this->sPage->store($request->all());
        if ($page) {
            return $this->respondData('Page created',  $page);
        }
        return $this->respondWithErrors(500, 'Error creating the page');
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
            $page = PageModel::find($id);
            if ($page) {
                return $this->respondData('Page',  $page);
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
            $page = $this->sPage->update($request->all());
            if ($page) {
                return $this->respondData('Page updated',  $page);
            }
            return $this->respondWithErrors(500, 'Error updating the page');
        }
        return $this->respondWithErrors(404, 'Page not found');
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
            $page = PageModel::find($id);
            if ($page) {
                if ($page->delete()) {
                    return $this->respondData('Page deleted',  $page);
                } else {
                    return $this->respondWithErrors(500, 'Error deleting the page');
                }
            }
        }
        return $this->respondWithErrors(404, 'Page not found');
    }

}
