<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Sort extends Base
{
    public Closure|string|null $name = 'Sort';

    public function getShouldGenerate(): bool
    {
        return $this->getSortableColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_SORTABLE_COLUMNS' => $this->getSortableColumns($this->resource)->keys(),
        ];
    }
}
