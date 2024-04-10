<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Exist extends Base
{
    public string $name = 'Exist';

    public ?string $group = 'Page/Index/Table/Columns';

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
