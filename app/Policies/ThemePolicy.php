<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThemePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return true;
    }

    public function store(User $user)
    {
        return $user->superAdmin;
    }

    public function update(User $user)
    {
        return $user->superAdmin;
    }

    public function destroy(User $user)
    {
        return $user->superAdmin;
    }
}
