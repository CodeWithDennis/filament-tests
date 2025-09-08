<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanBulkDeleteRecordsTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.can-bulk-delete-records';

    public function getShouldRender(): bool
    {
        return true;
    }
}
