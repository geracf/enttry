<?php

namespace App\Observers;

use App\User;
use App\Property;

class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        $properties = new Property;
        $user->properties()->save($properties);
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        if ($user->picture) {
            $user->picture->delete();
        }
        if ($user->applied_offers) {
            $user->applied_offers()->delete();
        }
        if ($user->featured_work) {
            $user->featured_work()->delete();
        }
        if ($user->education) {
            $user->education()->delete();
        }
        if ($user->favorites) {
            $user->favorites()->delete();
        }
        if ($user->documents) {
            $user->documents()->delete();
        }
        $user->properties->delete();
    }
}
