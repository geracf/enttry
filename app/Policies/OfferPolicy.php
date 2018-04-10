<?php

namespace App\Policies;

use App\User;
use App\Offer;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
    use HandlesAuthorization;

    public function search(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the offer.
     *
     * @param  \App\User  $user
     * @param  \App\Offer  $offer
     * @return mixed
     */
    public function view(User $user, Offer $offer)
    {
        if ($user->role_id == 3) {
            return true;
        } else {
            if ($user->organization->id == $offer->organization_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create offers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->role->create_offers &&
            $user->organization &&
            $user->organization->remaining_offers >= 1) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the offer.
     *
     * @param  \App\User  $user
     * @param  \App\Offer  $offer
     * @return mixed
     */
    public function update(User $user, Offer $offer)
    {
        if ($user->role->update_offers) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the offer.
     *
     * @param  \App\User  $user
     * @param  \App\Offer  $offer
     * @return mixed
     */
    public function delete(User $user, Offer $offer)
    {
        if ($user->role->delete_offers) {
            return true;
        }
        return false;
    }

    public function applications(User $user, Offer $offer)
    {
        if ($user->organization_id == $offer->organization_id) {
            if ($user->role->read_applications) {
                return true;
            }
        }
        return false;
    }

    public function favorite(User $user, Offer $offer)
    {
        if ($user->role_id == 3) {
            return true;
        }
    }

    public function apply(User $user, Offer $offer)
    {
        if ($user->role_id == 3 &&
            !$user->appliedOffers->contains('offer_id', $offer->id)) {
            return true;
        }
        return false;
    }

    public function viewDetails(User $user, Offer $offer)
    {
        return $user->organization_id == $offer->organization_id;
    }
}
