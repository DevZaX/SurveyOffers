<?php

namespace App\Policies;

use App\User;
use App\Offer;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
    use HandlesAuthorization;

    public function update(User $user,Offer $offer){
    	return $user->superAdmin || $offer->user_id == $user->id;
    }

     public function destroy(User $user,Offer $offer){
    	return $user->superAdmin || $offer->user_id == $user->id;
    }

    public function index(User $user){
    	return $user->superAdmin;
    }
}
