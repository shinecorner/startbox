<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class LocationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['body' => $request->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['id' => $id]);
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
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['id' => $id, 'body' => $request->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['id' => $id]);
    }

    public function settings(Request $request)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['body' => $request->all()]);
    }
}
