<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Search extends Base
{
    public string $name = 'Search';

    public ?string $group = 'Page/Index/Table/Columns';

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
