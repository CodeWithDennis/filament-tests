<?php

namespace CodeWithDennis\FilamentTests\Commands;

use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithFilesystem;
use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithUserInput;
use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use CodeWithDennis\FilamentTests\TestRenderers\BeforeEach;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Create\CanRenderCreatePageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit\CanRenderEditPageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanNotRenderColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderIndexPageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\View\CanRenderViewPageTest;
use Illuminate\Console\Command;

class FilamentTestsCommand extends Command
{
    use InteractsWithFilesystem;
    use InteractsWithUserInput;

    protected $signature = 'make:filament-test
                            {--skip-pint : Skip running Pint on generated files}
                            {--force : Overwrite existing test files without confirmation}';

    protected $description = 'Create tests for your Filament resources';

    public function handle(): void
    {
        $this->panels = $this->askUserToSelectPanels();
        $this->resources = $this->askUserToSelectResourcesFromTheSelectedPanels();

        $this->generateTests();

        $this->showGenerationSummary();

        $this->runPintOnGeneratedTests();
    }

    /**
     * @return class-string<BaseTest>[]
     */
    protected function getRenderers(): array
    {
return [
    BeforeEach::class,

    /*
    |--------------------------------------------------------------------------
    | Index Page Tests
    |--------------------------------------------------------------------------
    |
    | These tests cover rendering the index page and its columns. They ensure
    | that all expected columns can be displayed and that restricted columns
    | are not accessible.
    |
    */
    CanRenderIndexPageTest::class,
    CanRenderColumnTest::class,
    CanNotRenderColumnTest::class,

    /*
    |--------------------------------------------------------------------------
    | Create Page Tests
    |--------------------------------------------------------------------------
    |
    | These tests verify that the create page renders properly, ensuring that
    | users can access and interact with the form.
    |
    */
    CanRenderCreatePageTest::class,

    /*
    |--------------------------------------------------------------------------
    | Edit Page Tests
    |--------------------------------------------------------------------------
    |
    | These tests make sure the edit page can be rendered correctly and that
    | form inputs behave as expected.
    |
    */
    CanRenderEditPageTest::class,

    /*
    |--------------------------------------------------------------------------
    | View Page Tests
    |--------------------------------------------------------------------------
    |
    | These tests validate that the view page renders correctly, displaying
    | all necessary data for the resource.
    |
    */
    CanRenderViewPageTest::class,
];

    }
}
