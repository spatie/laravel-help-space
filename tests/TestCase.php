<?php

namespace Spatie\HelpSpace\Tests;

use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\HelpSpace\HelpSpaceServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__ . '/TestSupport/resources/views');
    }

    protected function getPackageProviders($app)
    {
        return [
            HelpSpaceServiceProvider::class,
        ];
    }
}
