<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanUpdateRecordTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.edit.can-update-record';

    public function getShouldRender(): bool
    {
        return $this->hasPage('edit');
    }
}
