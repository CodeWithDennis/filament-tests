<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Url extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasTableActionWithUrl($this->resource);
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_ACTIONS_WITH_URL' => $this->transformToPestDataset($this->getTableActionsWithUrlValues($this->resource), ['name', 'url']),
        ];
    }
}
