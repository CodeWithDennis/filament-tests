<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Create;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanCreateRecordTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.create.can-create-record';

    public function getShouldRender(): bool
    {
        return $this->hasPage('create');
    }
}
