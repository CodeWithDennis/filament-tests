<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Fields;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Hidden extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has a hidden field on edit form';
    }

    public function getShouldGenerate(): bool
    {
        return collect($this->getResourceEditFields())
            ->filter(fn ($field) => $field->isHidden())->count();
    }

    public function getVariables(): array
    {
        return [
            'EDIT_PAGE_HIDDEN_FIELDS' => $this->convertDoubleQuotedArrayString(collect($this->getResourceEditFields())->filter(fn ($field) => $field->isHidden())->keys()),
        ];
    }
}
