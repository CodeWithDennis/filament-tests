<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Create\Form;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;
use Filament\Forms\Form;

class Exists extends Base
{
    public Closure|bool $isTodo = true;

    public function getShouldGenerate(): bool
    {
        return $this->getResourceCreateForm($this->resource)::class == Form::class;
    }
}
