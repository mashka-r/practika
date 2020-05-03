<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    
    public function index(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }

    public function create(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }

    public function update(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }
}
