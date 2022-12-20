<?php

namespace Spatie\HelpSpace\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\HelpSpace\HelpSpace
 */
class HelpSpace extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Spatie\HelpSpace\HelpSpace::class;
    }
}
