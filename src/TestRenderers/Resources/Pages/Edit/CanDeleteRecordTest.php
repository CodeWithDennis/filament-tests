<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanDeleteRecordTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.edit.can-delete-record';

    public function getShouldRender(): bool
    {
        return true; // TODO: Check if action exists.
    }
}
