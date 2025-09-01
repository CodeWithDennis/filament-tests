<?php

namespace CodeWithDennis\FilamentTests\Commands;

use CodeWithDennis\FilamentTests\Concerns\Commands\HasGenerationSummary;
use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithFilesystem;
use CodeWithDennis\FilamentTests\Concerns\Commands\InteractsWithUserInput;
use Illuminate\Console\Command;

class FilamentTestsCommand extends Command
{
    use HasGenerationSummary;
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
}
