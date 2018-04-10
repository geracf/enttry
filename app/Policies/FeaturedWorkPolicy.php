<?php

namespace App\Policies;

use App\User;
use App\Student\FeaturedWork;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeaturedWorkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the featuredWork.
     *
     * @param  \App\User  $user
     * @param  \App\FeaturedWork  $featuredWork
     * @return mixed
     */
    public function view(User $user, FeaturedWork $featuredWork)
    {
        if ($user->id == $featuredWork->user_id) {
            return true;
        } elseif ($user->role_id < 3) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create featuredWorks.
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
     * Determine whether the user can update the featuredWork.
     *
     * @param  \App\User  $user
     * @param  \App\FeaturedWork  $featuredWork
     * @return mixed
     */
    public function update(User $user, FeaturedWork $featuredWork)
    {
        if ($user->id == $featuredWork->user_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the featuredWork.
     *
     * @param  \App\User  $user
     * @param  \App\FeaturedWork  $featuredWork
     * @return mixed
     */
    public function delete(User $user, FeaturedWork $featuredWork)
    {
        if ($user->id == $featuredWork->user_id) {
            return true;
        }
        return false;
    }
}
