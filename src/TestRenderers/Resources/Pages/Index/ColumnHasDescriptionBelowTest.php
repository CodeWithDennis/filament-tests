<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class ColumnHasDescriptionBelowTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.column-has-description-below';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableTextColumnsWithDescriptionBelow()->isNotEmpty();
    }
}
