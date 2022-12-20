<?php

namespace Spatie\HelpSpace;

use Closure;
use Illuminate\View\View;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

class HelpSpace
{
    protected ?Closure $sidebarClosure = null;

    public function sidebar(Closure $sidebarClosure): self
    {
        $this->sidebarClosure = $sidebarClosure;

        return $this;
    }

    public function sidebarContents(HelpSpaceRequest $request): string
    {
        $html = $this->sidebarClosure
            ? ($this->sidebarClosure)($request)
            : '';

        if ($html instanceof View) {
            $html = $html->render();
        }

        return $html;
    }
}
