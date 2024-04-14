<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns;

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
            'RESOURCE_TABLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getTableColumns($this->resource)->keys()),
        ];
    }
}
