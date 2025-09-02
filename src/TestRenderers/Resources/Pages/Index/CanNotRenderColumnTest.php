<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanNotRenderColumnTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.cannot-render-column';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceInitiallyHiddenTableColumns()->isNotEmpty();
    }
}
