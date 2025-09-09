<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class ColumnHasExtraAttributesTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.column-has-extra-attributes';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceTableColumnsWithExtraAttributes()->isNotEmpty();
    }
}
