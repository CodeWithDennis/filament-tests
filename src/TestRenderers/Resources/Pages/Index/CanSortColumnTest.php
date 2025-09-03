<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanSortColumnTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.can-sort-column';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableSortableColumns()->isNotEmpty();
    }
}
