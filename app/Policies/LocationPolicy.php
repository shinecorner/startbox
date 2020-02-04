<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function view(User $user, Location $location)
    {
        return true;
    }

    /**
     * Determine whether the user can create locations.
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
     * Determine whether the user can update the location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function update(User $user, Location $location)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function delete(User $user, Location $location)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function restore(User $user, Location $location)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function forceDelete(User $user, Location $location)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
