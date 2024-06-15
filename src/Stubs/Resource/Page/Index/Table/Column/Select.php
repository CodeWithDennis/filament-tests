<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Column;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Select extends Base
{
    public function getDescription(): string
    {
        return 'has select column with correct options';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->getTableSelectColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_SELECT_COLUMNS' => $this->transformToPestDataset($this->getTableSelectColumnsWithOptions($this->resource), ['column', 'options']),
        ];
    }
}
