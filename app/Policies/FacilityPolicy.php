<?php

namespace App\Policies;

use App\Models\Facility;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacilityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the facility.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facility  $facility
     * @return mixed
     */
    public function view(User $user, Facility $facility)
    {
        return true;
    }

    /**
     * Determine whether the user can create facilitys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return true;
    }

    /**
     * Determine whether the user can update the facility.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facility  $facility
     * @return mixed
     */
    public function update(User $user, Facility $facility)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the facility.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facility  $facility
     * @return mixed
     */
    public function delete(User $user, Facility $facility)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the facility.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facility  $facility
     * @return mixed
     */
    public function restore(User $user, Facility $facility)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the facility.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Facility  $facility
     * @return mixed
     */
    public function forceDelete(User $user, Facility $facility)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
