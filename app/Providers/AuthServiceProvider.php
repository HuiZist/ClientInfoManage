<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->is_admin === 66 || $user->is_admin === 67;
        });

        Gate::define('isSupAdmin', function ($user) {
            return $user->is_admin === 67;
        });

        Gate::define('canEditorAccount', function ($user,$account) {
            return $user->account == $account || $user->is_admin === 66 || $user->is_admin === 67;
        });

        Gate::define('canEditorId', function ($user,$id) {
            return $user->id == $id || $user->is_admin === 66 || $user->is_admin === 67;
        });
    }
}
