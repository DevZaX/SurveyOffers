<?php

namespace App\Policies;

use App\User;
use App\Offer;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
    use HandlesAuthorization;

    public function update(User $user){
    	return $user->superAdmin;
    }

     public function destroy(User $user){
    	return $user->superAdmin ;
    }

    public function store(User $user)
    {
        return $user->superAdmin ;
    }

    public function index(User $user){
    	return $user->superAdmin;
    }
}
