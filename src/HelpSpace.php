<?php

namespace Spatie\HelpSpace;

use Closure;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

class HelpSpace
{
    protected ?Closure $sidebarClosure = null;

    public function sidebar(Closure $sidebarClosure): self
    {
        $this->sidebarClosure = $sidebarClosure;

        return $this;
    }

    public function sidebarContents(HelpSpaceRequest $request)
    {
        return $this->sidebarClosure
            ? ($this->sidebarClosure)($request)
            : '';
    }
}
