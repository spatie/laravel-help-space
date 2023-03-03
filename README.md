# Integrate HelpSpace in your Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-help-space.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-help-space)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/spatie/laravel-help-space/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/laravel-help-space/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/spatie/laravel-help-space/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/spatie/laravel-help-space/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-help-space.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-help-space)

[HelpSpace](https://helpspace.com) is a beautiful help desk service. One of its features is that it can display a sidebar with extra information about the person that opened a ticket. 

![sidebar](https://github.com/spatie/laravel-help-space/blob/main/docs/sidebar.jpg?raw=true)

HelpSpace sends a request to your app to get the HTML content to populate that sidebar. Our package makes it easy to validate if an incoming request from HelpSpace is valid and allows you to respond to it.

When installed, this is how you can respond to an incoming request from HelpSpace.

```php
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

HelpSpace::sidebar(function(HelpSpaceRequest $request) {
    $user = User::firstWhere('email', $request->email())
    
    if (! $user) {
        return 'No user found';
    }
    
    // any view of your own in which you render the html
    // to be displayed at HelpSpace
    return view('help-space.sidebar', compact('user'));
})
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-help-space.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-help-space)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-help-space
```

To publish the config file and to create the `app/Providers/HelpSpaceServiceProvider.app` class in your app, run this command.

```bash
php artisan help-space:install
```

This is the contents of the published config file at `config/help-space.php` app:

```php
return [
    /*
     * The secret used to verify if the incoming HelpSpace secret is valid
     */
    'secret' => env('HELP_SPACE_SECRET'),

    /*
     * The package will automatically register this route to handle incoming
     * requests from HelpSpace.
     *
     * You can set this to `null` if you prefer to register your route manually.
     */
    'url' => '/help-space',

    /*
     * These middleware will be applied on the automatically registered route.
     */
    'middleware' => [
        Spatie\HelpSpace\Http\Middleware\IsValidHelpSpaceRequest::class,
        'api',
    ],
];
```

Next, In your `.env` file, you must set a new env-variable called  `HELP_SPACE_SECRET` to a random string. At [HelpSpace](https://helpspace.com) you must navigate to the "Custom Ticket sidebar" in the integration settings. There you must input that random string.  This secret will be used to verify if an incoming request is really coming from HelpSpace.

![settings](https://github.com/spatie/laravel-help-space/blob/main/docs/settings.jpg?raw=true)

The package will automatically register a route at `/help-space`. This route [can be customized](#customizing-the-registered-route).

## Usage

If you ran the install command from the section above, then your application a `HelpSpaceServiceProvider.php` service provider in `app/Providers`. This is the content.

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\HelpSpace\Facades\HelpSpace;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

class HelpSpaceServiceProvider extends ServiceProvider
{
    public function register()
    {
        HelpSpace::sidebar(function(HelpSpaceRequest $request) {        
            return "HTML about {$request->email()}";
        });
    }
}
```

The callable in `sidebar` will be executed whenever HelpSpace sends a request to your app. The `email()` method of   the given `HelpSpaceRequest` will contain the email address of the person that opened the ticket.

Instead of returning a string, you can also return a view.

```php
HelpSpace::sidebar(function(HelpSpaceRequest $request) {
    $user = User::firstWhere('email', $request->email());
    
    return view('your-own-view', compact('user'));        
}
```

## Preview the content of the sidebar

When working on the view that returns the HTML of the sidebar, it can be handy to preview it locally, instead of letting HelpScout sending requests.

To see the HTML for a given email address, you can use the `help-space:render-sidebar` command.

```bash
# returns the HTML for the given email address
php artisan help-space:render-sidebar --email=john@example.com
```

## Customizing the registered route

The package will automatically register a route at `/help-space`. You can change this value in the `help-space.php` config file.

Alternatively, you can register your own route.

First, you must set the `url` key in the `help-space.php` config file to `null`

Next, you must add this to your routes file, preferably `routes/api.php` so that your app doesn't start a session when a new request comes in from HelpSpace.

```php
// in a routes file, preferable in routes/api.php

Route::helpSpaceSidebar('your-custom-segment');
```

The above route will register a route with URL `https://yourdomain.com/api/your-custom-segment` (when you registered it in the api.php routes file.)

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
