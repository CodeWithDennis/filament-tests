<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanSearchColumnTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.can-search-column';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableSearchableColumns()->isNotEmpty();
    }
}
