<?php

namespace CodeWithDennis\FilamentTests\Concerns\Commands;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;
use function Laravel\Prompts\warning;

trait InteractsWithFilesystem
{
    protected array $generatedFiles = [];

    protected function getGeneratedFiles(): array
    {
        return $this->generatedFiles;
    }

    protected function runPintOnGeneratedTests(): void
    {
        if (empty($this->getGeneratedFiles()) || $this->option('skip-pint')) {
            return;
        }

        $files = collect($this->getGeneratedFiles())
            ->map(fn ($resources) => collect($resources)->pluck('path'))
            ->flatten()
            ->implode(' ');

        Process::run("vendor/bin/pint {$files}");
    }

    protected function getTestFilePath(string $resourceClass): string
    {
        $relativeClass = str($resourceClass)
            ->replaceFirst('App\\', '')
            ->replace('\\', '/');

        return base_path("tests/Feature/{$relativeClass}Test.php");
    }

    protected function generateTestsForSelectedResource(string $resource, ?string $panel = null): void
    {
        $filePath = $this->getTestFilePath($resource);
        $force = (bool) $this->option('force');

        if (File::exists($filePath) && ! $force && ! confirm("The tests for {$resource} already exists. Do you want to overwrite it?", false)) {
            info("Skipped generating test for {$resource}.");

            return;
        }

        $renderedTests = $this->renderTestsForResource($resource);

        File::ensureDirectoryExists(dirname((string) $filePath));
        File::put($filePath, $renderedTests['content']);

        $panelKey = $panel ?? 'default';

        $this->generatedFiles[$panelKey][$resource] = [
            'path' => $filePath,
            'num_tests' => $renderedTests['num_tests'],
        ];

    }

    protected function generateTests(): void
    {
        collect($this->getSelectedResources())
            ->each(function (array $resources, string $panelId): void {
                collect($resources)
                    ->flatten()
                    ->each(fn (string $resourceClass) => $this->generateTestsForSelectedResource($resourceClass, $panelId));
            });

    }

    protected function renderTestsForResource(string $resource): array
    {
        BaseTest::resetGeneratedTestsCounter();

        $renderers = collect($this->getRenderers());

        $output = $renderers
            ->map(fn (string $renderer) =>
            /** @var BaseTest $renderer */
            $renderer::build($resource)->render())
            ->prepend('<?php')
            ->implode("\n\n");

        return [
            'content' => $output,
            'num_tests' => BaseTest::getGeneratedTestsCounter(),
        ];
    }

    protected function showGenerationSummary(): void
    {
        if (blank($this->getGeneratedFiles())) {
            warning('No test files were generated.');

            return;
        }

        $rows = collect($this->getGeneratedFiles())
            ->flatMap(fn (array $resources, string $panelName) => collect($resources)
                ->map(fn (array $data, string $resource): array => [
                    $resource,
                    $panelName,
                    $data['num_tests'] ?? 0,
                ])
            )
            ->values()
            ->all();

        table(
            ['Resource', 'Panel', '# Tests'],
            $rows
        );
    }

    protected function runPestOnGeneratedTests(): void
    {
        if ($this->getGeneratedFiles() === [] || $this->option('skip-pest')) {
            return;
        }

        if (! confirm(
            label: 'Would you like to run Pest on the generated test files?',
            hint: 'You can always run Pest later by executing `vendor/bin/pest --group=filament-tests`',
        )) {
            return;
        }

        $result = spin(
            callback: fn () => \Illuminate\Support\Facades\Process::run('vendor/bin/pest --colors=always --group=filament-tests'),
            message: 'Running Pest tests...'
        );

        echo $result->output();

        if (confirm($result->successful()
            ? "Looks like the tests passed! That's great. Would you like to star the repo on GitHub ⭐️?"
            : "Looks like some tests failed. But hey, that's a good thing! 🥳 Please consider starring the repo on GitHub ⭐ after you’ve reviewed the test results."
        )) {
            $this->openUrlInBrowser('https://www.github.com/CodeWithDennis/filament-tests');
        }
    }
}
