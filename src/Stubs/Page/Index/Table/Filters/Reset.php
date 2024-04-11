<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Filters;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Reset extends Base
{
    public Closure|string|null $name = 'Reset';

    public function getShouldGenerate(): bool
    {
        return $this->getResourceTableFilters($this->getResourceTable($this->resource))->contains('reset');
    }
}
