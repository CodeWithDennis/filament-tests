<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use Filament\Actions\DeleteAction;

class CanDeleteRecordTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.edit.can-delete-record';

    public function getShouldRender(): bool
    {
        $action = $this->getPageHeaderAction(page: 'edit', action: 'delete', withDummyModel: true);

        return $action instanceof DeleteAction
            && $action->isVisible();
    }
}
