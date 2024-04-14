<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Search extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->getSearchableColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_SEARCHABLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getSearchableColumns($this->resource)->keys()),
        ];
    }
}
