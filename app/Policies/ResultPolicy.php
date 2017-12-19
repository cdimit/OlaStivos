<?php

namespace App\Policies;

use App\User;
use App\Result;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResultPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Determine if the given result can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $result
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->isAdmin();
    }
}
