<?php

namespace Spatie\HelpSpace\Commands;

use Illuminate\Console\Command;

class HelpSpaceCommand extends Command
{
    public $signature = 'laravel-help-space';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
