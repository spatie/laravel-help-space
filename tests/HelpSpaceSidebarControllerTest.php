<?php

use App\Http\Api\Controllers\HelpSpaceController;
use Illuminate\Support\Facades\Route;
use Spatie\HelpSpace\Facades\HelpSpace;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

beforeEach(function() {
   HelpSpace::sidebar(function(HelpSpaceRequest $request) {
        return "content of sidebar for user {$request->email()}";
   });

   Route::helpSpaceSidebar();

   config()->set('help-space.secret', 'my-secret');
});

it('can render the content of the sidebar', function () {
    $email = 'john@example.com';

    $response = $this
        ->postJson('help-space',
            ['from_contact' => ['value' => $email]],
            [
                'signature' => hash_hmac(
                    'sha256',
                    json_encode(['from_contact' => ['value' => $email]]),
                    config('help-space.secret'),
                ),
            ]
        )
        ->assertSuccessful()
        ->json();

    expect($response['html'])->toBe('content of sidebar for user john@example.com');
});

it('will return forbidden for a wrongly signed help-space request', function() {
    $this
        ->postJson(
            'help-space',
            ['from_contact' => ['value' => 'user@example.com']],
            [
                'signature' => hash_hmac('sha256', json_encode(['from_contact' => ['value' => 'tampered-payload']]), config('services.help-space.secret')),
            ]
        )
        ->assertForbidden();
});

it('will return forbidden for non signed HelpSpace request', function() {
    $this
        ->postJson('help-space', ['from_contact' => ['value' => 'john@example.com']])
        ->assertForbidden();
});
