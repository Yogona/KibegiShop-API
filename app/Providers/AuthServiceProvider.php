<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use \App\Policies\UserPolicy;

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
    }
}
