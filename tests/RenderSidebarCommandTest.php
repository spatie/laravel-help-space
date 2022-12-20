<?php

use App\Http\Api\Controllers\HelpSpaceController;
use Illuminate\Support\Facades\Route;
use Spatie\HelpSpace\Facades\HelpSpace;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;
use function Pest\Laravel\artisan;

beforeEach(function() {
   HelpSpace::sidebar(function(HelpSpaceRequest $request) {
        return "content of sidebar for user {$request->email()}";
   });
});

it('can render the sidebar for a given email', function() {
    artisan('help-space:render-sidebar', ['--email' => 'john@example.com'])->assertSuccessful();

    $this->expectOutputString('content of sidebar for user john@example.com');
});
