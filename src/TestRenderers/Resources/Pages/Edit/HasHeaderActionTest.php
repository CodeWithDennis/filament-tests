<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class HasHeaderActionTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.edit.has-header-action';

    public function getShouldRender(): bool
    {
        return $this->hasPage('edit')
            && $this->getPageHeaderActions('edit') !== [];
    }
}
