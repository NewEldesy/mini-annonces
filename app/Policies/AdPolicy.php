<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Ad $ad)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->exists;
    }

    public function update(User $user, Ad $ad)
    {
        return $user->id === $ad->user_id || $user->isAdmin();
    }

    public function delete(User $user, Ad $ad)
    {
        return $user->id === $ad->user_id || $user->isAdmin();
    }
}