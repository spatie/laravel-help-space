<?php

use function Pest\Laravel\artisan;
use Spatie\HelpSpace\Facades\HelpSpace;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

beforeEach(function () {
    HelpSpace::sidebar(function (HelpSpaceRequest $request) {
        return "content of sidebar for user {$request->email()}";
    });
});

it('can render the sidebar for a given email', function () {
    artisan('help-space:render-sidebar', ['--email' => 'john@example.com'])->assertSuccessful();

    $this->expectOutputString('content of sidebar for user john@example.com');
});
