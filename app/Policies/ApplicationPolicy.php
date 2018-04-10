<?php

namespace App\Policies;

use App\User;
use App\Student\Application;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function view(User $user, Application $application)
    {
        if ($user->role->read_applications) {
            if ($user->organization_id == $application->offer->organization_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create applications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->isStudent()) {
            if ($user->name && $user->university && $user->foi && $user->availability &&
                $user->dob && $user->major && $user->subtitle && $user->sex && $user->active) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can update the application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function update(User $user, Application $application)
    {
        if ($user->id == $application->user_id) {
            return true;
        } elseif ($user->organization_id == $application->offer->organization_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function delete(User $user, Application $application)
    {
        if ($user->id == $application->user_id) {
            return true;
        }
        return false;
    }
}
