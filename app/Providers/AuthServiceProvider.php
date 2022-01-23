<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use \App\Policies\UserPolicy;
use \App\policies\PayProfilePolicy;
use \App\Policies\BusinessProfilePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\User' =>'App\Policies\UserPolicy',
         'App\Models\PaymentProfile' => 'App\Policies\PayProfilePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* Authorizations */

        //User profile
        Gate::define('view-user', [UserPolicy::class, 'canViewUser']);
        Gate::define('update-user', [UserPolicy::class, 'canUpdateUser']);
        Gate::define('delete-user', [UserPolicy::class, 'canDeleteUser']);
        Gate::define('disable-user', [UserPolicy::class, 'canDisableUser']);

        //Payment profile 
        Gate::define('view-pay-profile', [PayProfilePolicy::class, 'canViewPayProfile']);
        Gate::define('update-pay-profile', [PayProfilePolicy::class, 'canUpdatePayProfile']);
        Gate::define('delete-pay-profile', [PayProfilePolicy::class, 'canDeletePayProfile']);

        //Business profile
        Gate::define('add-business-profile', [BusinessProfilePolicy::class, 'canAddBusinessProfile']);
        Gate::define('view-business-profile', [BusinessProfilePolicy::class, 'canViewBusinessProfile']);
        Gate::define('update-business-profile', [BusinessProfilePolicy::class, 'canUpdateBusinessProfile']);
    }
}
