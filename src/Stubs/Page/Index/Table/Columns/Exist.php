<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Exist extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->getTableColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_COLUMNS' => $this->getTableColumns($this->resource)->keys(),
        ];
    }
}