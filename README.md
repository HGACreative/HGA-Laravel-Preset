# HGA Laravel Presets

This package is intended to be used by employees and colleagues of [HGA](https://www.hgacreative.com), but has been made public as the wider community may also benefit from some of these presets. A list of the tweaks we have made are documented below.

## App

### Models
- Moved the `App\User` model into an appointed `Models` folder (`App\Models`), which we favour the structure of for cleaner code on larger projects
- Updates the `User` model to break down the "name" column into "first name" and "last name"
- Creates a `Role` model, including relationship to the `User` model

### Controllers
- Updated the Auth controllers to not redirect to `/home` because this route no longer exists
- Updated any reference of the `User` model to be `App\Models\User`
- Added a `PageController.php` for handling our default index route to take the closure away from the `web.php` routes file

### Providers
- Updated the default name of the Laravel Passport cookie
- Added a Gate to determine if the user is an admin or not. By default, this option is not used when first running the hga preset
- Added a boilerplate for a View Composer Service Provider. Our recommendation is to use the path `App\Http\ViewComposers` when creating any view composer as per the commentary.

### Traits
- We have, by default, a number of useful traits that we call on in projects - automating Uuids when they're being used for IDs on models as well as the User ID for models requiring the authenticated user's ID when saving
- There's also a handy trait for determining whether a user has a particular role - the naming for this is up for debate as there may be other models beyond the `User` who could possibly be assigned roles in the future

## Config
- Default api driver has been updated from 'token' to 'passport' to reflect our dependancy on the Laravel Passport package
- Default Mailgun endpoint updated to point to the EU server
- Updated to use encrypted sessions and secure session cookies only
  - **This configuration means any dev work will have to see the website served using [Laravel Valet](https://laravel.com/docs/master/valet) with a secure TLS certificate in place. Running over HTTP will throw a 419 error.**
- Updated any reference of the `User` model to be `App\Models\User`

## Database
- Updated migrations to reflect the changes on the `User` model
- Migrations for the `Role` model and subsequent many-to-many relationship with our `App\Models\User` model
- Added a `UsersTableSeeder.php` and a `RolesTableSeeder.php` to get things started
- Removed the `UserFactor.php` for the time being

## Resources
- Default JS and SASS files have been updated to HGA standard configurations
- Overwrites the default layout structure from Laravel into something more 'us'
- Updates to the authentication scaffolding to account for the "first name" and "last name" options on the `User` model, but also to the styling because we don't use Bootstrap.
  - **This update means you have no reason to run** `php artisan make:auth`

## Routes
- `api.php` has been updated to prefix "v1" to the routes, which is good practice for software to account for when the API evolves over time
- `web.php` has been updated to include Laravel's `Auth::routes()` to handle authentication, whilst removing the stock routes created after running `php artisan make:auth`

## Webpack
- By default, versioning is enabled
- Libraries such as VueJS and Axios are extracted to a `vendor.js` file

## Misc
- Includes Laravel Passport middleware for the `$web` array within `App\Http\Kernel.php`
- Includes a custom validator `strong_password` to ensure a weak password cannot be used when registering
- Additional parameters have been appended to the end of the .env file, including:
  - A Google Analytics param to hold the track ID, which will pre-populate the areas within the `layouts/app.blade.php` view
  - Mailgun parameters
  - Mail parameters
  - Session secure cookie (for ease of access in case Valet is unavailable to you)
- The package.json file has been updated to:
  - **Remove**
    - bootstrap
    - lodash
    - jquery
    - popper.js
  - **Include**
    - fontawesome-free
    - es6-promise
    - sass
    - sass-loader
    - vue-template-compiler

## API Access
- Our preset ships with Laravel Passport to consume any API created via JavaScript (typically using a VueJS & Axios combination)
- By default, we ignore the Passport migrations because we're not requiring such functionality within our applications, but it's good to know it's there
  - Turning these migrations back on is as simple as commenting out or removing the line `Passport::ignoreMigrations()`, which is in the `register()` method of  `AppServiceProvider.php`
