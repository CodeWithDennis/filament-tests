<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanRenderIndexPageTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.can-render-index-page';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index');
    }
}
