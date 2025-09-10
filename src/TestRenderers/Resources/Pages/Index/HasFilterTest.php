<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class HasFilterTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.has-filter';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableFilters()->isNotEmpty();
    }
}
