<?php

use Spatie\HelpSpace\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function calculateSignature(string $email): string
{
    return hash_hmac(
        'sha256',
        json_encode(['from_contact' => ['value' => $email]]),
        config('help-space.secret'),
    );
}
