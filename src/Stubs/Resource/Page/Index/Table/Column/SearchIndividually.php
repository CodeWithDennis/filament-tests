<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Column;

use CodeWithDennis\FilamentTests\Stubs\Base;

class SearchIndividually extends Base
{
    public function getDescription(): string
    {
        return 'can individually search by column';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getIndividuallySearchableColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_INDIVIDUALLY_SEARCHABLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getIndividuallySearchableColumns($this->resource)->keys()),
        ];
    }
}
