<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Version;
use Illuminate\Auth\Access\HandlesAuthorization;

class VersionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the update.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Version  $update
     * @return mixed
     */
    public function view(User $user, Version $update)
    {
        return true;
    }

    /**
     * Determine whether the user can create updates.
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
     * Determine whether the user can update the update.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Version  $update
     * @return mixed
     */
    public function update(User $user, Version $update)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the update.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Version  $update
     * @return mixed
     */
    public function delete(User $user, Version $update)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the update.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Version  $update
     * @return mixed
     */
    public function restore(User $user, Version $update)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the update.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Version  $update
     * @return mixed
     */
    public function forceDelete(User $user, Version $update)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
