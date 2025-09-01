<?php

namespace CodeWithDennis\FilamentTests\Concerns\Commands;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use CodeWithDennis\FilamentTests\TestRenderers\BeforeEach;
use CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index\CanRenderIndexPageTest;
use Illuminate\Support\Collection;

trait RendersFilamentTests
{
    protected function renderTestsForResource(string $resource): string
    {
        /** @var Collection<class-string<BaseTest>> $renderers */
        $renderers = collect($this->getRenderers());

        return $renderers
            ->map(fn (string $renderer) =>
                /** @var BaseTest $renderer */
                $renderer::build($resource)->render())
            ->prepend('<?php')
            ->implode("\n\n");
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
