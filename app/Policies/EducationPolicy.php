<?php

namespace App\Policies;

use App\User;
use App\Student\Education;
use Illuminate\Auth\Access\HandlesAuthorization;

class EducationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the education.
     *
     * @param  \App\User  $user
     * @param  \App\Student\Education  $education
     * @return mixed
     */
    public function view(User $user, Education $education)
    {
        if ($user->id == $education->user_id) {
            return true;
        } elseif ($user->role_id < 3) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create education.
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
     * Determine whether the user can update the education.
     *
     * @param  \App\User  $user
     * @param  \App\Student\Education  $education
     * @return mixed
     */
    public function update(User $user, Education $education)
    {
        if ($user->id == $education->user_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the education.
     *
     * @param  \App\User  $user
     * @param  \App\Student\Education  $education
     * @return mixed
     */
    public function delete(User $user, Education $education)
    {
        if ($user->id == $education->user_id) {
            return true;
        }
        return false;
    }
}
