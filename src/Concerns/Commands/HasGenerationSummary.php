<?php

namespace CodeWithDennis\FilamentTests\Concerns\Commands;

use function Laravel\Prompts\table;

trait HasGenerationSummary
{
    protected function showGenerationSummary(): void
    {
        if (blank($this->generatedFiles)) {
            $this->comment('No test files were generated.');

            return;
        }

        $rows = collect($this->generatedFiles)
            ->flatMap(fn ($resources, $panelId) => collect($resources)
                ->map(fn ($path, $resource): array => [
                    class_basename($resource),
                    $panelId,
                    str($path)
                        ->match('/tests\/Feature\/.*/')
                        ->when(fn ($relative): bool => $relative !== null, function ($relative) {
                            $filename = basename($relative);
                            $directory = str($relative)->beforeLast($filename);

                            // Highlights the output like: <fg=gray>tests/Feature/**/</>UserResourceTest.php
                            return str($directory)
                                ->wrap('<fg=gray>', '</>')
                                ->append($filename);
                        }),
                ])
            )
            ->values()
            ->all();

        table(
            ['Resource', 'Panel', 'Test File'],
            $rows
        );
    }
}
