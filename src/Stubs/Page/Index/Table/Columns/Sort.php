<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Sort extends Base
{
    public string $name = 'Sort';

    public ?string $group = 'Page/Index/Table/Columns';

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
