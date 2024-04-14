<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Edit\Form;

use CodeWithDennis\FilamentTests\Stubs\Base;
use Filament\Forms\Form;

class Exists extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->getResourceEditForm($this->resource)::class == Form::class;
    }
}
