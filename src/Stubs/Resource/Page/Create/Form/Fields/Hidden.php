<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Fields;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Hidden extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has a hidden field on create form';
    }

    public function getShouldGenerate(): bool
    {
        return collect($this->getResourceCreateFields($this->resource))
            ->filter(fn ($field) => $field->isHidden())->count();
    }

    public function getVariables(): array
    {
        return [
            'CREATE_PAGE_HIDDEN_FIELDS' => $this->convertDoubleQuotedArrayString(collect($this->getResourceCreateFields($this->resource))->filter(fn ($field) => $field->isHidden())->keys()),
        ];
    }
}
