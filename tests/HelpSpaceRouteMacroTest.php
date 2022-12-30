<?php

use Illuminate\Support\Facades\Route;
use Spatie\HelpSpace\Facades\HelpSpace;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

beforeEach(function () {
    HelpSpace::sidebar(function (HelpSpaceRequest $request) {
        return "content of sidebar for user {$request->email()}";
    });

    config()->set('help-space.secret', 'my-secret');

    Route::helpSpaceSidebar('other-url');
});

it('can render the content of the sidebar on the macro route', function () {
    $email = 'john@example.com';

    $response = $this
        ->postJson(
            uri: 'other-url',
            data: ['from_contact' => ['value' => $email]],
            headers: ['signature' => calculateSignature($email)]
        )
        ->assertSuccessful()
        ->json();

    expect($response['html'])->toBe('content of sidebar for user john@example.com');
});

it('will return forbidden for a wrongly signed help-space request on the macro-route', function () {
    $this
        ->postJson(
            uri: 'other-url',
            data: ['from_contact' => ['value' => 'john@example.com']],
            headers: ['signature' => calculateSignature('invalid-value')]
        )
        ->assertForbidden();
});
