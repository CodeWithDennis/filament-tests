<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class ColumnHasCorrectStateTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.column-has-correct-state';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableVisibleColumns()->isNotEmpty();
    }
}
