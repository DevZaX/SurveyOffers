<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $user){
        return $user->superAdmin == 1;
    }

    public function edit(User $auth,User $user){
    	return $auth->id == $user->id;
    }
}
