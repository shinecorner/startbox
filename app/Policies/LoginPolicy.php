<?php

namespace App\Policies;

use App\Models\Login;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoginPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the login.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Login  $login
     * @return mixed
     */
    public function view(User $user, Login $login)
    {
        return true;
    }

    /**
     * Determine whether the user can create logins.
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
     * Determine whether the user can update the login.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Login  $login
     * @return mixed
     */
    public function update(User $user, Login $login)
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->id === $login->user_id)	{
			return true;
		}
        return false;
    }

    /**
     * Determine whether the user can delete the login.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Login  $login
     * @return mixed
     */
    public function delete(User $user, Login $login)
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->id === $login->user_id)	{
			return true;
		}
        return false;
    }

    /**
     * Determine whether the user can restore the login.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Login  $login
     * @return mixed
     */
    public function restore(User $user, Login $login)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the login.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Login  $login
     * @return mixed
     */
    public function forceDelete(User $user, Login $login)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
