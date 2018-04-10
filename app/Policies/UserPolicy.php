<?php

namespace App\Policies;

use App\Organization;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    public $offers;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user, User $subject)
    {
        // dd($user->id == $subject->id);
        if ($user->id == $subject->id) {
            return true;
        } elseif ($user->role_id < 3 && $subject->role_id == 3) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->role_id == 1) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user, User $subject)
    {
        if ($user->id == $subject->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, User $subject)
    {
        //
    }

    public function search(User $user)
    {
        if ($user->role_id < 3) {
            return true;
        }
        return false;
    }

    public function subscribe(User $user)
    {
        if ($user->role_id == 1) {
            return true;
        }
        return false;
    }

    public function contact(User $user, User $subject)
    {
        if ($user->role_id < 3) {
            if ($user->organization instanceof Organization && $user->organization->remaining_discover > 0) {
                return true;
            }
        }
        return false;
    }

    public function contactDirectly(User $user, User $subject)
    {
        if ($user->role_id < 3) {
            if ($user->organization instanceof Organization) {
                $this->offers = $user->organization->offers->pluck('id');
                return $subject->appliedOffers->whereIn('offer_id', $this->offers)->count() > 0;
            }
        }
        return false;
    }
}
