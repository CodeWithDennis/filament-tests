<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Search extends Base
{
    public Closure|string|null $name = 'Search';

    public function getShouldGenerate(): bool
    {
        return $this->getSearchableColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_SEARCHABLE_COLUMNS' => $this->getSearchableColumns($this->resource)->keys(),
        ];
    }
}
