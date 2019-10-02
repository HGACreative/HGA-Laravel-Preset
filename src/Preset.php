<?php

namespace Hgacreative\HgaLaravelPreset;

use Illuminate\Foundation\Console\PresetCommand;

use Illuminate\Foundation\Console\Presets\Preset as LaravelPreset;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\File;

class Preset extends LaravelPreset
{
    /**
     * Install the hga preset.
     *
     * @param  \Illuminate\Foundation\Console\PresetCommand  $command
     */
    public static function install(PresetCommand $command)
    {
        $command->warn('Updating package.json & Laravel Mix');
        // root Directory
        static::updatePackages();
        static::updateLaravelMix();

        $command->warn('Appending new items to the .env file');
        static::updateEnv();

        // app Directory
        $command->warn('Working on the app directory');
        static::updateDefaultModels();
        static::updateDefaultControllers();
        static::loadTraits();
        static::updateKernel();
        static::updateProviders();

        // config Directory
        $command->warn('Updating configurations');
        static::copyUpdatedConfigurations();

        // database Directory
        $command->warn('Updating database files');
        static::resetMigrations();
        static::resetFactories();
        static::resetSeeds();

        // resources Directory
        $command->warn('Updating resources');
        static::cleanAssetDirectories();
        static::updateJsResources();
        static::updateSassResources();
        static::resetViews();

        // routes Directory
        $command->warn('Refactoring our routes');
        static::updateRoutes();
    }

    /**
     * Move the default model into a specific "Models" dir
     *
     * @return  void
     */
    public static function updateDefaultModels()
    {
        // check the path exists in-case we are re-running
        static::deleteFile(app_path('User.php'));
        static::makeDirectory(app_path('Models'));

        $files = [
            'User.php',
            'Role.php'
        ];

        static::copyNewFiles($files, 'app/models', 'app_path', 'Models');
    }

    /**
     * Update the default controllers
     *
     * @return  void
     */
    public static function updateDefaultControllers()
    {
        // empty the default controllers directory
        static::cleanDirectory(app_path('Http/Controllers'));

        $files = [
            'Controller.php',
            'PageController.php',
        ];

        // copy in the basic controllers
        static::copyNewFiles($files, 'app/controllers', 'app_path', 'Http/Controllers');
        // add in controllers for authentication
        static::createAuthControllers();
    }

    /**
     * Create the Auth controllers, which are almost identical to
     * the default Laravel controllers but with minor tweaks to the
     * redirect path to account for the fact that there is no "home"
     * url to go to
     *
     * @return  void
     */
    public static function createAuthControllers()
    {
        static::makeDirectory(app_path('Http/Controllers/Auth'));

        $files = [
            'ForgotPasswordController.php',
            'LoginController.php',
            'RegisterController.php',
            'ResetPasswordController.php',
            'VerificationController.php',
        ];

        static::copyNewFiles($files, 'app/controllers/auth', 'app_path', 'Http/Controllers/Auth');
    }

    /**
     * Load in HGA's stock traits
     *
     * @return  void
     */
    public static function loadTraits()
    {
        static::makeDirectory(app_path('Traits'));

        $files = [
            'AutomateUuid.php',
            'AutomateAuthUserAssociation.php',
            'UserRoles.php'
        ];

        static::copyNewFiles($files, 'app/traits', 'app_path', 'Traits');
    }

    /**
     * Update the kernel to include the Passport CreateFreshApiToken middleware
     *
     * @return  void
     */
    public static function updateKernel()
    {
        static::copyNewFiles(['Kernel.php'], 'app', 'app_path', 'Http');
    }

    /**
     * Update the default service providers
     *
     * @return  void
     */
    public static function updateProviders()
    {
        $files = [
            'AppServiceProvider.php',
            'AuthServiceProvider.php',
            'ViewComposerServiceProvider.php',
        ];

        static::copyNewFiles($files, 'app/providers', 'app_path', 'Providers');
    }

    /**
     * Update some of the default configurations
     *
     * @return  void
     */
    public static function copyUpdatedConfigurations()
    {
        $files = [
            'auth.php',
            'services.php',
            'session.php',
        ];

        static::copyNewFiles($files, 'config', 'config_path');
    }

    /**
     * Clean the assets directory by emptying specific folders
     *
     * @return  void
     */
    public static function cleanAssetDirectories()
    {
        foreach(['sass', 'js'] as $dir)
            static::cleanDirectory(resource_path($dir));
    }

    /**
     * Remove the existing database migrations and copy in
     * the custom HGA migrations
     *
     * @return  void
     */
    public static function resetMigrations()
    {
        static::cleanDirectory(database_path('migrations'));
        static::copyNewMigrations();
    }

    /**
     * Reset the factories folder to empty. We will leave it as such
     * because we're going to populate the migrations with HGA seeders
     *
     * @return  void
     */
    public static function resetFactories()
    {
        static::cleanDirectory(database_path('factories'));
        static::makeFile(database_path('factories/.gitkeep'));
    }

    /**
     * Reset the seeds folder to empty and copy in new seeders for the Role
     * and User models
     *
     * @return  void
     */
    public static function resetSeeds()
    {
        static::cleanDirectory(database_path('seeds'));
        static::copyNewSeeds();
    }

    /**
     * Copy the new seeder files into the application
     *
     * @return  void
     */
    public static function copyNewSeeds()
    {
        $files = [
            'DatabaseSeeder.php',
            'UsersTableSeeder.php',
            'RolesTableSeeder.php'
        ];

        static::copyNewFiles($files, 'database/seeds', 'database_path', 'seeds');
    }

    /**
     * Copy the new migration files into the application
     *
     * @return  void
     */
    public static function copyNewMigrations()
    {
        $files = [
            '2019_01_01_000000_create_users_table.php',
            '2019_01_01_100000_create_password_resets_table.php',
            '2019_01_01_200000_create_roles_table.php',
            '2019_01_01_300000_create_role_user_pivot_table.php',
        ];

        static::copyNewFiles($files, 'database/migrations', 'database_path', 'migrations');
    }

    /**
     * Update the existing routes files to better reflect HGA's
     * set up for Laravel applications
     *
     * @return  void
     */
    public static function updateRoutes()
    {
        $files = [
            'api.php',
            'web.php'
        ];

        static::copyNewFiles($files, 'routes', 'base_path', 'routes');
    }

    /**
     * Add in typical packages that are usually manually imported and
     * remove those that aren't required.
     *
     * @param  array  $packages
     * @return  void
     */
    public static function updatePackageArray($packages)
    {
        return array_merge([
            '@fortawesome/fontawesome-free' => '*',
            'es6-promise' => '*',
            'sass' => '*',
            'sass-loader' => '*',
            'vue' => '*',
            'vue-template-compiler' => '*',
        ],
        Arr::except($packages, [
            'bootstrap',
            'lodash',
            'jquery',
            'popper.js',
        ]));
    }

    /**
     * Update Laravel's default mix file to extract libraries and
     * kick-off the project with versioning in place
     *
     * @return  void
     */
    public static function updateLaravelMix()
    {
        $files = [
            'webpack.mix.js'
        ];

        static::copyNewFiles($files, 'stubs', 'base_path');
    }

    /**
     * Add new items to the existing .env file
     *
     * @return  void
     */
    public static function updateEnv()
    {
        static::appendToExistingFile('.env', 'stubs', 'base_path');
    }

    /**
     * Copy new javascript files into the application
     *
     * @return  void
     */
    public static function updateJsResources()
    {
        $files = [
            'app.js',
            'bootstrap.js',
        ];

        static::copyNewFiles($files, 'resources/js', 'resource_path', 'js');
    }

    /**
     * Copy new sass files into the application
     *
     * @return  void
     */
    public static function updateSassResources()
    {
        $files = [
            'app.scss',
            '_mixins.scss',
            '_grid.scss',
            '_vars.scss',
            '_skeleton.scss',
        ];

        static::copyNewFiles($files, 'resources/sass', 'resource_path', 'sass');
    }

    /**
     * Remove the existing application views and copy in
     * the updated, custom HGA view files
     *
     * @return  void
     */
    public static function resetViews()
    {
        static::cleanDirectory(resource_path('views'));
        static::createViews();
    }

    /**
     * Copy new view files into the application
     *
     * @return  void
     */
    public static function createViews()
    {
        $layoutFiles = [
            'app.blade.php',
        ];
        $layoutBlockFiles = [
            'header.blade.php',
            'nav.blade.php',
            'footer.blade.php',
        ];
        $authFiles = [
            'login.blade.php',
            'register.blade.php',
            'verify.blade.php',
        ];
        $authPasswordFiles = [
            'email.blade.php',
            'reset.blade.php',
        ];
        $viewFiles = [
            'index.blade.php',
        ];

        static::makeDirectory(resource_path('views/layouts'));
        static::copyNewFiles($layoutFiles, 'resources/views/layouts', 'resource_path', 'views/layouts');

        static::makeDirectory(resource_path('views/layouts/blocks'));
        static::copyNewFiles($layoutBlockFiles, 'resources/views/layouts/blocks', 'resource_path', 'views/layouts/blocks');

        static::makeDirectory(resource_path('views/auth'));
        static::copyNewFiles($authFiles, 'resources/views/auth', 'resource_path', 'views/auth');

        static::makeDirectory(resource_path('views/auth/passwords'));
        static::copyNewFiles($authPasswordFiles, 'resources/views/auth/passwords', 'resource_path', 'views/auth/passwords');

        static::copyNewFiles($viewFiles, 'resources/views', 'resource_path', 'views');
    }

    /**
     * Clean out a given directory
     *
     * @param  string  $dir
     * @return  void
     */
    public static function cleanDirectory(string $dir)
    {
        File::cleanDirectory($dir);
    }

    /**
     * Make a directory within the application
     *
     * @param  string  $dir
     * @return  void
     */
    public static function makeDirectory(string $dir)
    {
        if(!File::exists($dir)) {
            File::makeDirectory($dir);
        }
    }

    /**
     * Make a file within the applixation
     *
     * @param  string  $filePath
     * @param  string  $contents
     * @return  void
     */
    public static function makeFile(string $filePath, string $contents = "")
    {
        if(!File::exists($filePath)) {
            File::put($filePath, $contents);
        }
    }

    /**
     * Append new data to existing files within the application
     *
     * @param  string  $fileName
     * @param  string  $localPath
     * @param  string  $pathFunction
     * @param  string  $subDir
     * @return  void
     */
    public static function appendToExistingFile(string $fileName, string $localPath, string $pathFunction, string $subDir = "")
    {
        file_put_contents(
            $pathFunction($subDir.$fileName),
            file_get_contents(sprintf("%s/%s/%s", __DIR__, $localPath, $fileName)),
            FILE_APPEND
        );
    }

    /**
     * Delete an existing file from the application
     * @param  string  $filePath
     * @return  void
     */
    public static function deleteFile(string $filePath)
    {
        if(File::exists($filePath)) {
            File::delete($filePath);
        }
    }

    /**
     * Copy new custom files from the package to the applicaton
     *
     * @param  array  $files
     * @param  string  $localPath
     * @param  string  $pathFunction
     * @param  string  $subDir
     * @return  void
     */
    public static function copyNewFiles(array $files, string $localPath, string $pathFunction, string $subDir = '')
    {
        // if a sub directory to copy to has been specified
        if($subDir) {
            // check if there's a trailing slash
            $subDir = Str::endsWith($subDir, '/')
                ? $subDir
                : $subDir.'/';
        }

        // loop and copy into the application
        foreach($files as $file)
            copy(sprintf("%s/%s/%s", __DIR__, $localPath, $file), $pathFunction($subDir . $file));
    }
}
