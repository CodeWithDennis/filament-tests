<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class ShowsColumnTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.shows-column';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableVisibleColumns()->isNotEmpty();
    }
}
