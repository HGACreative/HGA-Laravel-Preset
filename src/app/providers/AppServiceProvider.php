<?php

namespace App\Providers;

use App\Models\User;

use Illuminate\Support\Facades\Blade;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // create @env
        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });

        /**
         * Is the user's password strong? I.e. contains one upper, lower, numeric and special character?
         * This also acts as a fallback to ensure the password is at least eight characters long.
         *
         */
         Validator::extend(
             'strong_password',
             function($attribute, $value, $parameters, $validator) {
                $is_strong = preg_match("((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,30})", $value);
                return ($is_strong) ? true : false;
            },
            "Your password isn't strong enough - it must contain at least one upper, lower, numeric and special charater"
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }
}
