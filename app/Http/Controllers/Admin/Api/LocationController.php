<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\ApiController;
use App\Services\Location;
use App\Models\Location as LocationModel;
use Illuminate\Http\Request;

class LocationController extends ApiController
{
    protected $sLocation;

    public function __construct(Location $sLocation)
    {
        $this->sLocation = $sLocation;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $options = $this->sLocation->standardize_search($request);
        $list = $this->sLocation->find($options);
        if (isset($options['limit']) && $options['limit'] > 0) {
            $this->setPagination($this->sLocation->get_paginator()->toArray());
        }
        return $this->respondData('Locations list',  $list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = $this->sLocation->store($request->all());
        if ($location) {
            return $this->respondData('Location created',  $location);
        }
        return $this->respondWithErrors(500, 'Error creating the location');
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
            $location = LocationModel::find($id);
            if ($location) {
                return $this->respondData('Location',  $location);
            }
        }
        return $this->respondWithErrors(404, 'Location not found');
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
            $location = $this->sLocation->update($request->all());
            if ($location) {
                return $this->respondData('Location updated',  $location);
            }
            return $this->respondWithErrors(500, 'Error updating the location');
        }
        return $this->respondWithErrors(404, 'Location not found');
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
            $locations = LocationModel::find($id);
            if ($locations) {
                if ($locations->delete()) {
                    return $this->respondData('Location deleted',  $locations);
                } else {
                    return $this->respondWithErrors(500, 'Error deleting the location');
                }
            }
        }
        return $this->respondWithErrors(404, 'Location not found');
    }

    public function settings(Request $request)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['body' => $request->all()]);
    }
}
