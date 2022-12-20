<?php

namespace Spatie\HelpSpace\Http\Controllers;

use Spatie\HelpSpace\HelpSpace;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

class HelpSpaceSidebarController
{
    public function __invoke(HelpSpaceRequest $request, HelpSpace $helpSpace)
    {
        return $helpSpace->sidebarContents($request);
    }
}
