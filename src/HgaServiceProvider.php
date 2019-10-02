<?php

namespace Hgacreative\HgaLaravelPreset;

use Illuminate\Foundation\Console\PresetCommand;

use Illuminate\Support\ServiceProvider;

class HgaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        PresetCommand::macro('hga', function($command) {
            Preset::install($command);

            $command->info('Application configured as an HGACreative application.');
            $command->info('Go make something beautiful, "Challenge The Ordinary".');
            $command->error('Now run "npm install --save" and then compile you assets with "npm run dev"!');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
