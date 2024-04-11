<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Exist extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasAnyTableAction($this->resource, $this->getTableActionNames($this->resource)->toArray());
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_ACTIONS' => $this->getTableActionNames($this->resource)->keys(),
        ];
    }
}
