<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class ShowsHeaderActionTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.edit.shows-header-action';

    public function getShouldRender(): bool
    {
        return $this->hasPage('edit')
            && ! $this->getPageHeaderVisibleActions('edit')->isEmpty();
    }
}
