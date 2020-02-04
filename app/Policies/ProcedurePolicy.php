<?php

namespace App\Policies;

use App\Models\Procedure;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProcedurePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the procedure.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Procedure  $procedure
     * @return mixed
     */
    public function view(User $user, Procedure $procedure)
    {
        return true;
    }

    /**
     * Determine whether the user can create procedures.
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
     * Determine whether the user can update the procedure.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Procedure  $procedure
     * @return mixed
     */
    public function update(User $user, Procedure $procedure)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the procedure.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Procedure  $procedure
     * @return mixed
     */
    public function delete(User $user, Procedure $procedure)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the procedure.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Procedure  $procedure
     * @return mixed
     */
    public function restore(User $user, Procedure $procedure)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the procedure.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Procedure  $procedure
     * @return mixed
     */
    public function forceDelete(User $user, Procedure $procedure)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
