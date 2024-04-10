<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure | string | null $name = 'Render';

    public Closure | string | null $group = 'Page/Index/Table/Columns';

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
