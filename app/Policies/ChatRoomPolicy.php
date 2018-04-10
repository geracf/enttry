<?php

namespace App\Policies;

use App\User;
use App\ChatRoom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatRoomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the chatRoom.
     *
     * @param  \App\User  $user
     * @param  \App\ChatRoom  $chatRoom
     * @return mixed
     */
    public function view(User $user, ChatRoom $chatRoom)
    {
        if ($user->id == $chatRoom->user_id) {
            return true;
        } elseif ($user->organization &&
            $chatRoom->application->offer->organization_id == $user->organization_id) {
            if ($user->organization->id == $chatRoom->application->offer->organization_id) {
                if ($user->role->read_applications) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create chatRooms.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the chatRoom.
     *
     * @param  \App\User  $user
     * @param  \App\ChatRoom  $chatRoom
     * @return mixed
     */
    public function update(User $user, ChatRoom $chatRoom)
    {
        if ($user->id == $chatRoom->user_id) {
            return true;
        } elseif ($user->organization_id && $chatRoom->application) {
            if ($user->organization_id == $chatRoom->application->offer->organization_id) {
                if ($user->role->read_applications) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the chatRoom.
     *
     * @param  \App\User  $user
     * @param  \App\ChatRoom  $chatRoom
     * @return mixed
     */
    public function delete(User $user, ChatRoom $chatRoom)
    {
        //
    }
}
