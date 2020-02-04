<?php

namespace App\Policies;

use App\Models\Recording;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the recording.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return mixed
     */
    public function view(User $user, Recording $recording)
    {
        return true;
    }

    /**
     * Determine whether the user can create recordings.
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
     * Determine whether the user can update the recording.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return mixed
     */
    public function update(User $user, Recording $recording)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the recording.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return mixed
     */
    public function delete(User $user, Recording $recording)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the recording.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return mixed
     */
    public function restore(User $user, Recording $recording)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the recording.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return mixed
     */
    public function forceDelete(User $user, Recording $recording)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }
}
