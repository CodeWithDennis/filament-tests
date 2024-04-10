<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use CodeWithDennis\FilamentTests\Stubs\Base;

class DescriptionBelow extends Base
{
    public string $name = 'DescriptionBelow';

    public ?string $group = 'Page/Index/Table/Columns';

    public function getShouldGenerate(): bool
    {
        return $this->getDescriptionBelowColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_DESCRIPTIONS_BELOW_COLUMNS' => $this->transformToPestDataset($this->getTableColumnDescriptionBelow($this->resource), ['column', 'description']),
        ];
    }
}
