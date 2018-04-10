<?php

namespace App\Policies;

use App\User;
use App\Student\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the document.
     *
     * @param  \App\User  $user
     * @param  \App\Student\Document  $document
     * @return mixed
     */
    public function view(User $user, Document $document)
    {
        return true;
    }

    /**
     * Determine whether the user can create documents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param  \App\User  $user
     * @param  \App\Student\Document  $document
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \App\User  $user
     * @param  \App\Student\Document  $document
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        return true;
    }
}
