<?php

namespace CodeWithDennis\FilamentTests\Commands;

use App\Filament\Resources\Users\UserResource;
use CodeWithDennis\FilamentTests\TestRenderers\BeforeEach;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Create\CanRenderCreatePageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit\CanRenderEditPageTest;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderIndexPageTest;
use Filament\Facades\Filament;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Process;
use function Laravel\Prompts\multiselect;

class FilamentTestsCommand extends Command
{
    protected $signature = 'make:filament-test
                            {--should-run-pint-after : Run Pint on generated files after tests}';

    protected $description = 'Create a new test for a Filament component';

    //    protected ?Collection $resources = null;

    public function __construct(
        protected ?Collection $resources = null,
        protected ?Collection $panels = null,
        protected array $generatedFiles = [],
        protected ?Filesystem $files = null,
    ) {
        $this->resources ??= collect();
        $this->panels ??= collect();
        $this->files ??= new Filesystem;
        parent::__construct();
    }

    public function handle(): void
    {
        //        $this->panels = $this->askUserToSelectPanels();
        //        $this->resources = $this->askUserToSelectWhichResourcesFromTheSelectedPanel();

        $this->panels = collect(['admin']);
        $this->resources = collect([
            'admin' => [
                UserResource::class,
            ],
        ]);

        foreach ($this->resources as $panelId => $resourceClasses) {
            foreach ($resourceClasses as $resourceClass) {
                $rendered = $this->renderTestsForResource($resourceClass);

                $filePath = $this->getTestFilePath($resourceClass);
                $this->files->ensureDirectoryExists(dirname($filePath));

                file_put_contents($filePath, $rendered);

                $this->generatedFiles[] = $filePath;

                $this->info("Created test for {$resourceClass} → {$filePath}");
            }
        }

        $this->runPintOnGeneratedFiles();
    }

    /**
     * Render all tests for a single resource.
     */
    protected function renderTestsForResource(string $resourceClass): string
    {
        return implode("\n\n", [
            BeforeEach::build($resourceClass)->render(),
            CanRenderIndexPageTest::build($resourceClass)->render(),
            //            CanRenderCreatePageTest::build($resourceClass)->render(),
            //            CanRenderEditPageTest::build($resourceClass)->render(),
        ]);
    }

    protected function runPintOnGeneratedFiles(): void
    {
        if ($this->generatedFiles === []) {
            return;
        }

        if ( ! $this->option('should-run-pint-after')) {
            return;
        }

        $files = implode(' ', $this->generatedFiles);

        Process::run("vendor/bin/pint {$files}");
    }

    protected function getTestFilePath(string $resourceClass): string
    {
        $relativeClass = str($resourceClass)
            ->replaceFirst('App\\', '')
            ->replace('\\', '/');

        return base_path("tests/Feature/{$relativeClass}Test.php");
    }

    protected function askUserToSelectPanels(): Collection
    {
        $allPanels = collect(Filament::getPanels());

        $selectedPanelIds = multiselect(
            label: 'Which Filament panel do you want to use?',
            options: $allPanels->mapWithKeys(fn ($panel) => [
                $panel->getId() => $panel->getId(),
            ])->toArray(),
        );

        return collect($selectedPanelIds);
    }

    public function askUserToSelectWhichResourcesFromTheSelectedPanel(): Collection
    {
        $resourcesByPanel = $this->panels->mapWithKeys(fn ($panelId) => [
            $panelId => collect(Filament::getPanel($panelId)?->getResources() ?? [])
                ->mapWithKeys(fn ($resource) => [$resource => class_basename($resource)])
                ->toArray(),
        ]);

        $selectedResources = collect();

        foreach ($this->panels as $panelId) {
            $resources = $resourcesByPanel[$panelId] ?? [];

            if (empty($resources)) {
                continue;
            }

            $selected = multiselect(
                label: "Select resources for panel: {$panelId}",
                options: $resources,
                required: true,
            );

            if (! empty($selected)) {
                $selectedResources[$panelId] = $selected;
            }
        }

        return $selectedResources;
    }
}
