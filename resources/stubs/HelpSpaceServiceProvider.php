<?php

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
