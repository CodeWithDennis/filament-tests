<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanRenderColumnTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.can-render-column';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableDefaultVisibleColumns()->isNotEmpty();
    }
}
