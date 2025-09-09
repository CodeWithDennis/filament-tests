<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class SelectColumnHasOptionsTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.select-column-has-options';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableSelectColumns()->isNotEmpty();
    }
}
