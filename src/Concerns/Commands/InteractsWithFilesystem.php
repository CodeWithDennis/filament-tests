<?php

namespace CodeWithDennis\FilamentTests\Concerns\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;

trait InteractsWithFilesystem
{
    use RendersFilamentTests;

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

        $renderResult = $this->renderTestsForResource($resource);

        File::ensureDirectoryExists(dirname((string) $filePath));
        File::put($filePath, $renderResult['content']);

        $panelKey = $panel ?? 'default';

        $this->generatedFiles[$panelKey][$resource] = [
            'path' => $filePath,
            'num_tests' => (int) $renderResult['num_tests'],
        ];
    }

    protected function generateTests(): void
    {
        collect($this->getSelectedResources())
            ->each(function ($resources, $panelId): void {
                collect($resources)
                    ->flatten()
                    ->each(fn (string $resourceClass) => $this->generateTestsForSelectedResource($resourceClass, $panelId));
            });
    }
}
