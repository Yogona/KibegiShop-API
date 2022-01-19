<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use \App\Policies\UserPolicy;
use \App\policies\PayProfilePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //User authorizations
        Gate::define('view-user', [UserPolicy::class, 'canViewUser']);
        Gate::define('update-user', [UserPolicy::class, 'canUpdateUser']);
        Gate::define('delete-user', [UserPolicy::class, 'canDeleteUser']);
        Gate::define('disable-user', [UserPolicy::class, 'canDisableUser']);

        //Payment profile authorizations
        Gate::define('view-pay-profile', [PayProfilePolicy::class, 'canViewPayProfile']);
        Gate::define('update-pay-profile', [PayProfilePolicy::class, 'canUpdatePayProfile']);
        Gate::define('delete-pay-profile', [PayProfilePolicy::class, 'canDeletePayProfile']);
    }
}
