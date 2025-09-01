<?php

namespace CodeWithDennis\FilamentTests\Concerns\Commands;

use function Laravel\Prompts\table;
use function Laravel\Prompts\warning;

trait HasGenerationSummary
{
    protected function showGenerationSummary(): void
    {
        if (blank($this->generatedFiles)) {
            warning('No test files were generated.');

            return;
        }

        $rows = collect($this->generatedFiles)
            ->flatMap(fn ($resources, $panelId) => collect($resources)
                ->map(fn ($data, $resource): array => [

                    // Resource
                    class_basename($resource),

                    // Panel
                    $panelId,

                    // # Tests
                    ($data['num_tests'] - 1), // -1 for BeforeEach
                ])
            )
            ->values()
            ->all();

        table(
            ['Resource', 'Panel', '# Tests'],
            $rows
        );
    }
}
