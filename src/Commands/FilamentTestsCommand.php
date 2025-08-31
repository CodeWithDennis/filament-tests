<?php

namespace CodeWithDennis\FilamentTests\Commands;

use App\Filament\Resources\Users\UserResource;
use CodeWithDennis\FilamentTests\TestRenderers\BeforeEach;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Create\CanRenderCreatePageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit\CanRenderEditPageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderIndexPageTest;
use Illuminate\Console\Command;

class FilamentTestsCommand extends Command
{
    protected $signature = 'make:filament-test';

    protected $description = 'Create a new test for a Filament component';

    public function handle(): void
    {
        // TODO: THIS IS JUST TESTING STUFF
        $resource = UserResource::class;

        $file = [
            BeforeEach::build($resource)->render(),
            CanRenderIndexPageTest::build($resource)->render(),
            CanRenderCreatePageTest::build($resource)->render(),
            CanRenderEditPageTest::build($resource)->render(),
        ];

        $this->info(implode("\n\n", $file));
    }
}
