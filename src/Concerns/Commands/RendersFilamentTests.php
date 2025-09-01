<?php

namespace CodeWithDennis\FilamentTests\Concerns\Commands;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

trait RendersFilamentTests
{
    protected function renderTestsForResource(string $resource): array
    {
        $renderers = collect($this->getRenderers());

        $output = $renderers
            ->map(fn (string $renderer) =>
                /** @var BaseTest $renderer */
                $renderer::build($resource)->render())
            ->prepend('<?php')
            ->implode("\n\n");

        return [
            'content' => $output,
            'num_tests' => $renderers->count(),
        ];
    }
}
