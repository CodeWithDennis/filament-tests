<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index;

use CodeWithDennis\FilamentTests\Stubs\Base;

class ListRecordsPaginated extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource) && $this->tableHasPagination($this->resource);
    }

    public function getVariables(): array
    {
        return [
            'DEFAULT_PER_PAGE_OPTION' => $this->convertDoubleQuotedArrayString($this->getTableDefaultPaginationPageOption($this->resource)),
            'DEFAULT_PAGINATED_RECORDS_FACTORY_COUNT' => $this->convertDoubleQuotedArrayString($this->getTableDefaultPaginationPageOption($this->resource) * 2),
        ];
    }
}
