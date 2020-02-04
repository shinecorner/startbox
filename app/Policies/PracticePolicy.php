<?php

namespace App\Policies;

use App\Models\Practice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PracticePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the practice.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practice  $practice
     * @return mixed
     */
    public function view(User $user, Practice $practice)
    {
        return true;
    }

    /**
     * Determine whether the user can create practices.
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
     * Determine whether the user can update the practice.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practice  $practice
     * @return mixed
     */
    public function update(User $user, Practice $practice)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the practice.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practice  $practice
     * @return mixed
     */
    public function delete(User $user, Practice $practice)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the practice.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practice  $practice
     * @return mixed
     */
    public function restore(User $user, Practice $practice)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the practice.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practice  $practice
     * @return mixed
     */
    public function forceDelete(User $user, Practice $practice)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
