<?php

namespace CodeWithDennis\FilamentTests\Commands;

use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithFilesystem;
use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithUserInput;
use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use CodeWithDennis\FilamentTests\TestRenderers\BeforeEach;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Create\CanRenderCreatePageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit\CanDeleteRecordTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit\CanRenderEditPageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanNotRenderColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderIndexPageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanSearchColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanSortColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\HasColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\HidesColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\ShowsColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\View\CanRenderViewPageTest;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FilamentTestsCommand extends Command
{
    protected Collection $panels;

    protected Collection $resources;

    protected bool $tableLoadingGloballyDeferred = false;

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
        $this->tableLoadingGloballyDeferred = $this->askUserIfTableLoadingIsGloballyDeferred();

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
            CanRenderIndexPageTest::class,
            CanRenderCreatePageTest::class,
            CanRenderEditPageTest::class,
            CanRenderViewPageTest::class,
            CanRenderColumnTest::class,
            CanNotRenderColumnTest::class,
            HasColumnTest::class,
            ShowsColumnTest::class,
            HidesColumnTest::class,
            CanSortColumnTest::class,
            CanSearchColumnTest::class,
            CanDeleteRecordTest::class,
        ];
    }
}
