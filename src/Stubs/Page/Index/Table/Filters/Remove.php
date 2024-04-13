<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Filters;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Remove extends Base
{
    public Closure|bool $isTodo = true;

    public function getShouldGenerate(): bool
    {
        return $this->getResourceTableFilters($this->getResourceTable($this->resource))->isNotEmpty();
    }
}
