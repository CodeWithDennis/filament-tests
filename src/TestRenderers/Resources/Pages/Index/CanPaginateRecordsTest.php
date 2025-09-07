<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanPaginateRecordsTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.can-paginate-records';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->isResourceTablePaginationEnabled();
    }
}
