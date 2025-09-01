<?php

namespace CodeWithDennis\FilamentTests\Concerns\Commands;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use CodeWithDennis\FilamentTests\TestRenderers\BeforeEach;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderIndexPageTest;

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
