<?php

namespace App\Services;

use App\Exceptions\AdminApiException as ApiException;
use App\Models\Organization;
use App\Models\User;
use App\Models\Facility;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Report
{
    protected $user;
    protected $organization;
    protected $facility;
    protected $location;

    public function __construct(User $user, Organization $organization, Facility $facility, Location $location)
    {
       $this->user = $user;
       $this->organization = $organization;
       $this->facility = $facility;
       $this->location = $location;
    }

    public function getUsersByStatus(array $status)
    {
        return $this->user->with('organization')
        ->whereIn('status', $status)
        ->get();
    }

    public function getUsers()
    {
        return $this->user
        ->with('organization')
        ->get();
    }

    public function getTotalUsers()
    {
        return $this->user->get();
    }

    public function getTotalOrganizations()
    {
        return $this->organization->get();
    }
    
    public function getTotalFacilities()
    {
        return $this->facility->get();
    }

    public function getTotalLocations()
    {
        return $this->location->get();
    }
}
