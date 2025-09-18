<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Edit;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanValidateEditFormData extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.edit.can-validate-edit-form-data';

    public function getShouldRender(): bool
    {
        return $this->hasPage('edit');
    }
}
