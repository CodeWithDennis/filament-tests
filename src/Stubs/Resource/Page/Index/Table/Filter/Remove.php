<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Filter;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Remove extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can remove a table filter';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getResourceTableFilters($this->getResourceTable($this->resource))->isNotEmpty();
    }
}
