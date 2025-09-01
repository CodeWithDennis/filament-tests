<?php

namespace CodeWithDennis\FilamentTests\Commands;

use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithFilesystem;
use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithUserInput;
use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use CodeWithDennis\FilamentTests\TestRenderers\BeforeEach;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderIndexPageTest;
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
            CanRenderIndexPageTest::class,
            // CanRenderCreatePageTest::class,
            // CanRenderEditPageTest::class,
        ];
    }
}
