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

    public function canDisableUser(User $currentUser, User $user){
        if($currentUser->id !== $user->id){
            return false;
        } 

        return true;
    }

    public function canDeleteUser(User $currentUser, User $user){
        if($currentUser->id !== $user->id){
            return false;
        } 

        return true;
    }

    public function canUpdateUser(User $currentUser, User $user){
        if($currentUser->id !== $user->id){
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
