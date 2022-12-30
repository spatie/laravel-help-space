<?php

use Illuminate\Support\Facades\Route;
use Spatie\HelpSpace\Facades\HelpSpace;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

beforeEach(function () {
    HelpSpace::sidebar(function (HelpSpaceRequest $request) {
        return "content of sidebar for user {$request->email()}";
    });

    config()->set('help-space.secret', 'my-secret');
});

it('can render the content of the sidebar', function () {
    $email = 'john@example.com';

    $response = $this
        ->postJson(
            uri: 'help-space',
            data: ['from_contact' => ['value' => $email]],
            headers: ['signature' => calculateSignature($email)]
        )
        ->assertSuccessful()
        ->json();

    expect($response['html'])->toBe('content of sidebar for user john@example.com');
});

it('can render the content of the sidebar using a view', function () {
    HelpSpace::sidebar(fn () => view('testView'));

    $response = $this
        ->postJson(
            uri: 'help-space',
            data: ['from_contact' => ['value' => 'john@example.com']],
            headers: ['signature' => calculateSignature('john@example.com')]
        )
        ->assertSuccessful()
        ->json();

    expect($response['html'])->toContain('This is a test view');
});

it('will return forbidden for a wrongly signed help-space request', function () {
    $this
        ->postJson(
            uri: 'help-space',
            data: ['from_contact' => ['value' => 'john@example.com']],
            headers: ['signature' => calculateSignature('invalid-value')]
        )
        ->assertForbidden();
});

it('will return forbidden for non signed HelpSpace request', function () {
    $this
        ->postJson(
            uri: 'help-space',
            data: ['from_contact' => ['value' => 'john@example.com']])
        ->assertForbidden();
});
