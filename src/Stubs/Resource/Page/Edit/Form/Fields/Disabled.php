<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Fields;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Disabled extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has a disabled X field on edit form';
    }

    public function getShouldGenerate(): bool
    {
        return collect($this->getResourceEditFields($this->resource))
            ->filter(fn ($field) => $field->isDisabled())->count();
    }
}
