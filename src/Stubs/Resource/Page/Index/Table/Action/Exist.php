<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Action;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Exist extends Base
{
    public function getDescription(): string
    {
        return 'has table action';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasAnyTableAction($this->resource, $this->getTableActionNames($this->resource)->toArray());
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_ACTIONS' => $this->getTableActionNames($this->resource)->keys(),
        ];
    }
}
