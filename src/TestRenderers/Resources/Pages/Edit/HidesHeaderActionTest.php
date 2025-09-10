<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class HidesHeaderActionTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.edit.hides-header-action';

    public function getShouldRender(): bool
    {
        return $this->hasPage('edit')
            && ! $this->getPageHeaderHiddenActions('edit')->isEmpty();
    }
}
