<?php

namespace Spatie\HelpSpace;

use Spatie\HelpSpace\Commands\HelpSpaceCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HelpSpaceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-help-space')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-help-space_table')
            ->hasCommand(HelpSpaceCommand::class);
    }
}
