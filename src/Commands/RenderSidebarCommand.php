<?php

namespace Spatie\HelpSpace\Commands;

use Illuminate\Console\Command;
use Spatie\HelpSpace\HelpSpace;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

class RenderSidebarCommand extends Command
{
    public $signature = 'help-space:render-sidebar {--email=}';

    public $description = 'Display';

    public function handle(): int
    {
        if (! $email = $this->option('email')) {
            $email = $this->ask('For which email?');
        }

        $payload = ['from_contact' => ['value' => $email]];

        $request = HelpSpaceRequest::create('fake', 'POST', content: json_encode($payload));

        $html = app(HelpSpace::class)->sidebarContents($request);

        $this->info("This is the render HTML for HelpSpace for {$email}");
        $this->info('');

        echo $html;

        return Command::SUCCESS;
    }
}
