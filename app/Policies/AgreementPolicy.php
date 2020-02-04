<?php

namespace App\Policies;

use App\Models\Agreement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgreementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the agreement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agreement  $agreement
     * @return mixed
     */
    public function view(User $user, Agreement $agreement)
    {
        return true;
    }

    /**
     * Determine whether the user can create agreements.
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
     * Determine whether the user can update the agreement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agreement  $agreement
     * @return mixed
     */
    public function update(User $user, Agreement $agreement)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the agreement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agreement  $agreement
     * @return mixed
     */
    public function delete(User $user, Agreement $agreement)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the agreement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agreement  $agreement
     * @return mixed
     */
    public function restore(User $user, Agreement $agreement)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the agreement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Agreement  $agreement
     * @return mixed
     */
    public function forceDelete(User $user, Agreement $agreement)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
