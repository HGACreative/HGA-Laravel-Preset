<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // view()->composer({dot notation path to blade file}, {App\Http\ViewComposers\{name of view composer})
    }
}
