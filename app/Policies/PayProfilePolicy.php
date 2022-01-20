<?php

namespace App\Policies;

use App\Models\PaymentProfile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayProfilePolicy
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

    // public function canDeletePayProfile(User $currentUser, PaymentProfile $payProfile){
    //     if($currentUser->id !== $user->id){
    //         return false;
    //     } 

    //     return true;
    // }

    // public function canUpdatePayProfile(User $currentUser, User $user){
    //     if($currentUser->id !== $user->id){
    //         return false;
    //     } 

    //     return true;
    // }

    public function canViewPayProfile(User $currentUser, PaymentProfile $payProfile){
        if($currentUser->id !== $payProfile->user_id){
            return false;
        } 

        return true;
    }
}
