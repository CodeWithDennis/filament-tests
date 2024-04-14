<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Fields;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Disabled extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has a disabled X field on create form';
    }

    public function getShouldGenerate(): bool
    {
        return collect($this->getResourceCreateFields($this->resource))
            ->filter(fn ($field) => $field->isDisabled())->count();
    }
}
