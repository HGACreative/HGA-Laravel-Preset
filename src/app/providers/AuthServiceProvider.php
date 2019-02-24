<?php

namespace App\Providers;

use App\Models\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::cookie('www_api_cookie');

        /**
         * The gate checks if the user can administrate the website
         *
         * @param \App\Models\User $user
         * @return bool
         */
        Gate::define('administrate', function(User $user) {
            return $user->isAdmin();
        });
    }
}
