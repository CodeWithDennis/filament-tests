<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns;

use CodeWithDennis\FilamentTests\Stubs\Base;

class DescriptionAbove extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->getDescriptionAboveColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_DESCRIPTIONS_ABOVE_COLUMNS' => $this->transformToPestDataset($this->getTableColumnDescriptionAbove($this->resource), ['column', 'description']),
        ];
    }
}
