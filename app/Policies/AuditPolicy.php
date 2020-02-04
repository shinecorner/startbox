<?php

namespace App\Policies;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuditPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the audit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Audit  $audit
     * @return mixed
     */
    public function view(User $user, Audit $audit)
    {
        return true;
    }

    /**
     * Determine whether the user can create audits.
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
     * Determine whether the user can update the audit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Audit  $audit
     * @return mixed
     */
    public function update(User $user, Audit $audit)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the audit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Audit  $audit
     * @return mixed
     */
    public function delete(User $user, Audit $audit)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the audit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Audit  $audit
     * @return mixed
     */
    public function restore(User $user, Audit $audit)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the audit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Audit  $audit
     * @return mixed
     */
    public function forceDelete(User $user, Audit $audit)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
