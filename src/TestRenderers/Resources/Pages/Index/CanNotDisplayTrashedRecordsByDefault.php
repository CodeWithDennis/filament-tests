<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Index;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanNotDisplayTrashedRecordsByDefault extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.index.cannot-display-trashed-records-by-default';

    public function getShouldRender(): bool
    {
        return $this->hasPage('index')
            && $this->getResourceModelHasSoftDeletes();
    }
}
