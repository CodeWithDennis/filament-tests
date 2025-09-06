<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use Filament\Actions\Action;

class CanDeleteRecordTest extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.edit.can-delete-record';

    public function getShouldRender(): bool
    {
        return $this->getPageHeaderAction(page: 'edit', action: 'delete') instanceof Action;
        /* TODO(fixme): We can't grab the delete action visiblity because it expects a record */
        /* $action->isVisible(); */
    }
}
