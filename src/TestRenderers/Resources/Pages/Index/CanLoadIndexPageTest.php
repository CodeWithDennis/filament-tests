<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanLoadIndexPageTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.can-load-index-page';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index');
    }
}
