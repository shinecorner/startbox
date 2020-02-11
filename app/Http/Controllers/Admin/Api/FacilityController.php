<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\ApiController;
use App\Services\Facility;
use App\Models\Facility as FacilityModel;
use Illuminate\Http\Request;

class FacilityController extends ApiController
{

    protected $sFacility;

    public function __construct(Facility $sFacility)
    {
        $this->sFacility = $sFacility;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $options = $this->sFacility->standardize_search($request);
        $list = $this->sFacility->find($options);
        if (isset($options['limit']) && $options['limit'] > 0) {
            $this->setPagination($this->sFacility->get_paginator()->toArray());
        }
        return $this->respondData('Facilities list',  $list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user'] = $request->user();
        $facility = $this->sFacility->store($data);
        if ($facility) {
            return $this->respondData('Facility created',  $facility);
        }
        return $this->respondWithErrors(500, 'Error creating the facility');
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
            $facility = FacilityModel::find($id);
            if ($facility) {
                return $this->respondData('Facility',  $facility);
            }
        }
        return $this->respondWithErrors(404, 'Facility not found');
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
            $facility = $this->sFacility->update($request->all());
            if ($facility) {
                return $this->respondData('Facility updated',  $facility);
            }
            return $this->respondWithErrors(500, 'Error updating the facility');
        }
        return $this->respondWithErrors(404, 'Facility not found');
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
            $facility = FacilityModel::find($id);
            if ($facility) {
                if ($facility->delete()) {
                    return $this->respondData('Facility deleted',  $facility);
                } else {
                    return $this->respondWithErrors(500, 'Error deleting the facility');
                }
            }
        }
        return $this->respondWithErrors(404, 'Facility not found');
    }

    //Non resources methods
    public function facility_locations($facility_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['facility_id' => $facility_id]);
    }

    public function show_facility_location($facility_id, $location_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['facility_id' => $facility_id, 'location_id' => $location_id]);
    }

    public function settings(Request $request)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['body' => $request->all()]);
    }
}
