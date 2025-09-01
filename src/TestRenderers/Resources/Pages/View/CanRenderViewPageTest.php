<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\View;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanRenderViewPageTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.view.can-render-view-page';

    public function getShouldRender(): bool
    {
        return $this->hasPage('view');
    }
}
