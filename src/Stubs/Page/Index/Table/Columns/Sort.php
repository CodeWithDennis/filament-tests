<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Sort extends Base
{
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
