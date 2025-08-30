<?php

namespace CodeWithDennis\FilamentTests\Commands;

use Illuminate\Console\Command;

class FilamentTestsCommand extends Command
{
    protected $signature = 'make:filament-test';

    protected $description = 'Create a new test for a Filament component';

    public function handle(): int
    {
        // TODO
    }
}
