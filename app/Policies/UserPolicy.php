<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function canUpdateUser(User $currentUser, User $searchUser){
        if($currentUser->id !== $searchUser->id){
            return false;
        } 

        return true;
    }

    public function canViewUser(User $currentUser, User $searchUser){
        if($currentUser->id !== $searchUser->id){
            return false;
        } 

        return true;
    }
}
