<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->getInitiallyVisibleColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_INITIALLY_VISIBLE_COLUMNS' => $this->getInitiallyVisibleColumns($this->resource)->keys(),
        ];
    }
}
