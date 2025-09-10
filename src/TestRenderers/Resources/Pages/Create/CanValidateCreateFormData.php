<?php

namespace CodeWithDennis\FilamentTests\TestRenderers\Resources\Pages\Create;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;

class CanValidateCreateFormData extends BaseTest
{
    public ?string $view = 'filament-tests::resources.pages.create.can-validate-create-form-data';

    public function getShouldRender(): bool
    {
        return $this->hasPage('create');
    }
}
