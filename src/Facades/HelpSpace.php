<?php

namespace Spatie\HelpSpace\Facades;

use Closure;
use Illuminate\Support\Facades\Facade;

class HelpSpace extends Facade
{
    /**
     * @method static \Spatie\HelpSpace\HelpSpace sidebar(Closure $closure)
     *
     * @see \Spatie\HelpSpace\HelpSpace
     */
    public static function getFacadeAccessor()
    {
        return \Spatie\HelpSpace\HelpSpace::class;
    }
}
