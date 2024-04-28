<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Column;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Sort extends Base
{
    public function getDescription(): string
    {
        return 'can sort column';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getSortableColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_SORTABLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getSortableColumns($this->resource)->keys()),
        ];
    }
}
