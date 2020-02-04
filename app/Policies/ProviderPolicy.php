<?php

namespace App\Policies;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function view(User $user, Provider $provider)
    {
        return true;
    }

    /**
     * Determine whether the user can create providers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function update(User $user, Provider $provider)
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isProvider() && $user->isSameAs($provider)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function delete(User $user, Provider $provider)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function restore(User $user, Provider $provider)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function forceDelete(User $user, Provider $provider)
    {
        return false;
    }
}
