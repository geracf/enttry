<?php

namespace App\Policies;

use App\User;
use App\Student\Favorite;
use Illuminate\Auth\Access\HandlesAuthorization;

class FavoritePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create favorites.
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
     * Determine whether the user can delete the favorite.
     *
     * @param  \App\User  $user
     * @param  \App\Favorite  $favorite
     * @return mixed
     */
    public function delete(User $user, Favorite $favorite)
    {
        if ($user->id == $favorite->user_id) {
            return true;
        }
        return false;
    }
}
