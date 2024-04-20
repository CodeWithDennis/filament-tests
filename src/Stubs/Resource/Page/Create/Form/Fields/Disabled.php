<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Fields;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Disabled extends Base
{
    public function getDescription(): string
    {
        return 'has a disabled field on create form';
    }

    public function getShouldGenerate(): bool
    {
        return collect($this->getResourceCreateFields($this->resource))
            ->filter(fn ($field) => $field->isDisabled())->count();
    }

    public function getVariables(): array
    {
        return [
            'CREATE_PAGE_DISABLED_FIELDS' => $this->convertDoubleQuotedArrayString(collect($this->getResourceCreateFields($this->resource))->filter(fn ($field) => $field->isDisabled())->keys()),
        ];
    }
}
