<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use Filament\Actions\Action;

class CanDeleteRecordTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.edit.can-delete-record';

    public function getShouldRender(): bool
    {
        return true;
        /* TODO: We can't grab the delete action because it expects a record */
        /* $action = $this->getPageHeaderAction(page: 'edit', action: 'delete'); */
        /* return $action instanceof Action && $action->isVisible(); */
    }
}
