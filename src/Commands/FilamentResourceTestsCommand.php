<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use Illuminate\Console\Command;

class FilamentResourceTestsCommand extends Command
{
    public $signature = 'filament-resource-tests';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
