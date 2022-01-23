<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use \App\Models\Role;
use \App\Models\BusinessProfile;

class BusinessProfilePolicy
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

    public function canAddBusinessProfile(User $currentUser){
        $userRole = $currentUser->role()->first()->name;
        
        if($userRole == "Buyer"){
            return false;
        }

        return true;
    } 

    public function canViewBusinessProfile(User $currentUser, BusinessProfile $businessProfile){
        if($currentUser->id != $businessProfile->user_id){
            return false;
        }

        return true;
    }

    public function canUpdateBusinessProfile(User $currentUser, BusinessProfile $businessProfile){
        if($currentUser->id != $businessProfile->user_id){
            return false;
        }

        return true;
    }
}
