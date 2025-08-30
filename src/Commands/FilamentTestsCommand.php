<?php

namespace CodeWithDennis\FilamentTests\Commands;

use CodeWithDennis\FilamentTests\TestRenderers\CanRenderCreatePageTest;
use CodeWithDennis\FilamentTests\TestRenderers\CanRenderEditPageTest;
use Illuminate\Console\Command;

class FilamentTestsCommand extends Command
{
    protected $signature = 'make:filament-test';

    protected $description = 'Create a new test for a Filament component';

    public function handle()
    {
        // TODO: THIS IS JUST TESTING STUFF
        $resource = 'App\Filament\Admin\Resources\BadgeResource'; // Replace with dynamic input

        $file = [
            CanRenderCreatePageTest::build($resource)->render(),
            CanRenderEditPageTest::build($resource)->render(),
        ];

        $this->info(implode("\n\n", $file));
    }
}
