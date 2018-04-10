<?php

namespace App\Policies;

use App\User;
use App\Student\WorkExperience;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkExperiencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the workExperience.
     *
     * @param  \App\User  $user
     * @param  \App\WorkExperience  $workExperience
     * @return mixed
     */
    public function view(User $user, WorkExperience $workExperience)
    {
        if ($user->id == $workExperience->user_id) {
            return true;
        } elseif ($user->role_id < 3) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create workExperiences.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->role_id == 3) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the workExperience.
     *
     * @param  \App\User  $user
     * @param  \App\WorkExperience  $workExperience
     * @return mixed
     */
    public function update(User $user, WorkExperience $workExperience)
    {
        if ($user->id == $workExperience->user_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the workExperience.
     *
     * @param  \App\User  $user
     * @param  \App\WorkExperience  $workExperience
     * @return mixed
     */
    public function delete(User $user, WorkExperience $workExperience)
    {
        if ($user->id == $workExperience->user_id) {
            return true;
        }
        return false;
    }
}
