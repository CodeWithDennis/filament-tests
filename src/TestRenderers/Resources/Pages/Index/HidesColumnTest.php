<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class HidesColumnTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.hides-column';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceHiddenTableColumns()->isNotEmpty();
    }
}
