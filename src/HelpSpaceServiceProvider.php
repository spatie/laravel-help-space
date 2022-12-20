<?php

namespace Spatie\HelpSpace;

use Illuminate\Support\Facades\Route;
use Spatie\HelpSpace\Commands\RenderSidebarCommand;
use Spatie\HelpSpace\Http\Controllers\HelpSpaceSidebarController;
use Spatie\HelpSpace\Http\Middleware\IsValidHelpSpaceRequest;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HelpSpaceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-help-space')
            ->hasConfigFile()
            ->hasCommand(RenderSidebarCommand::class);

        Route::macro('helpSpaceSidebar', function (string $url = 'help-space') {
            Route::post($url, HelpSpaceSidebarController::class)->middleware(IsValidHelpSpaceRequest::class);
        });
    }

    public function registeringPackage()
    {
        $this->app->scoped(HelpSpace::class, fn () => new HelpSpace());
    }
}
