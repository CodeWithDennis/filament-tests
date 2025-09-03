<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class HasColumnTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.has-column';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableColumns()->isNotEmpty();
    }
}
