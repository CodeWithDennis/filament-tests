<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class ColumnHasDescriptionAboveTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.column-has-description-above';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableTextColumnsWithDescriptionAbove()->isNotEmpty();
    }
}
