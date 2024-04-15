<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Fields;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Hidden extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has a hidden X field on edit form';
    }

    public function getShouldGenerate(): bool
    {
        return collect($this->getResourceEditFields($this->resource))
            ->filter(fn ($field) => $field->isHidden())->count();
    }
}
