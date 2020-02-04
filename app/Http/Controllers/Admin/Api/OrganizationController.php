<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\ApiController;
use App\Models\Organization as OrganizationModel;
use App\Services\Organization;
use Illuminate\Http\Request;

class OrganizationController extends ApiController
{

    protected $sOrganization;

    public function __construct(Organization $sOrganization)
    {
        $this->sOrganization = $sOrganization;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $options = $this->sOrganization->standardize_search($request);
        $list = $this->sOrganization->find($options);
        if (isset($options['limit']) && $options['limit'] > 0) {
            $this->setPagination($this->sOrganization->get_paginator()->toArray());
        }
        return $this->respondData('Organizations list',  $list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organization = $this->sOrganization->create($request->all());
        if ($organization) {
            return $this->respondData('Organization created',  $organization);
        }
        return $this->respondWithErrors(500, 'Error creating the organization');
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
            $organization = OrganizationModel::find($id);
            if ($organization) {
                return $this->respondData('Organization',  $organization);
            }
        }
        return $this->respondWithErrors(404, 'Organization not found');
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
            $organization = $this->sOrganization->update($request->all());
            if ($organization) {
                return $this->respondData('Organization updated',  $organization);
            }
            return $this->respondWithErrors(500, 'Error updating the organization');
        }
        return $this->respondWithErrors(404, 'Organization not found');
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
            $organization = OrganizationModel::find($id);
            if ($organization) {
                if ($organization->delete()) {
                    return $this->respondData('Organization deleted',  $organization);
                } else {
                    return $this->respondWithErrors(500, 'Error deleting the organization');
                }
            }
        }
        return $this->respondWithErrors(404, 'Organization not found');
    }


    //Non resources methods
    public function organization_facilities($organization_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['organization_id' => $organization_id]);
    }

    public function show_organization_facility($organization_id, $facility_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['organization_id' => $organization_id, 'facility_id' => $facility_id]);
    }

    public function organization_facility_locations($organization_id, $facility_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['organization_id' => $organization_id, 'facility_id' => $facility_id]);
    }

    public function organization_facility_location($organization_id, $facility_id, $location_id)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['organization_id' => $organization_id, 'facility_id' => $facility_id, 'location_id' => $location_id]);
    }


    public function domain_settings(Request $request)
    {
        //TODO
        return $this->respondData('Route reached at ' . url()->current(), ['body' => $request->all()]);
    }
}
