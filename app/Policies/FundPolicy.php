<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Fund;
use Illuminate\Auth\Access\HandlesAuthorization;

class FundPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user)
    {
        return true;
    }

    public function delete(User $user)
    {
        return true;
    }

    public function restore(User $user)
    {
        return true;
    }

    public function forceDelete(User $user)
    {
        return false;
    }
}
