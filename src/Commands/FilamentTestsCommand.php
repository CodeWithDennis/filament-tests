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
        $resource = 'App\Filament\Admin\Resources\UserResource';

        $file = [
            CanRenderCreatePageTest::build($resource)
                ->view('filament-tests::can-render-create-page')
                ->render(),

            CanRenderEditPageTest::build($resource)
                ->view('filament-tests::can-render-edit-page')
                ->render(),
        ];

        $this->info(implode("\n\n", $file));
    }
}
