<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\BulkAction;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Exist extends Base
{
    public function getDescription(): string
    {
        return 'has table bulk action';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasAnyTableBulkAction($this->resource, $this->getResourceTableBulkActions($this->resource)->keys()->toArray());
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_BULK_ACTIONS' => $this->convertDoubleQuotedArrayString($this->getResourceTableBulkActions($this->resource)->keys()),
        ];
    }
}
