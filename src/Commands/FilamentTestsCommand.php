<?php

namespace CodeWithDennis\FilamentTests\Commands;

use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithFilesystem;
use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithUserInput;
use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use CodeWithDennis\FilamentTests\TestRenderers\BeforeEach;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Create\CanRenderCreatePageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit\CanDeleteRecordTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit\CanRenderEditPageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanBulkDeleteRecordsTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanNotDisplayTrashedRecordsByDefault;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanNotRenderColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanPaginateRecordsTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderIndexPageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanSearchColumnIndividuallyTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanSearchColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanSortColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\ColumnHasDescriptionAboveTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\ColumnHasDescriptionBelowTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\ColumnHasExtraAttributesTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\HasColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\HidesColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\ShowsColumnTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\View\CanRenderViewPageTest;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FilamentTestsCommand extends Command
{
    use InteractsWithFilesystem;
    use InteractsWithUserInput;

    protected Collection $panels;

    protected Collection $resources;

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
            CanRenderIndexPageTest::class,
            CanRenderCreatePageTest::class,
            CanRenderEditPageTest::class,
            CanRenderViewPageTest::class,
            CanRenderColumnTest::class,
            CanNotRenderColumnTest::class,
            HasColumnTest::class,
            ShowsColumnTest::class,
            HidesColumnTest::class,
            ColumnHasDescriptionAboveTest::class,
            ColumnHasDescriptionBelowTest::class,
            ColumnHasExtraAttributesTest::class,
            CanSortColumnTest::class,
            CanSearchColumnTest::class,
            CanSearchColumnIndividuallyTest::class,
            CanDeleteRecordTest::class,
            CanNotDisplayTrashedRecordsByDefault::class,
            CanPaginateRecordsTest::class,
            CanBulkDeleteRecordsTest::class,
        ];
    }
}
