<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use CodeWithDennis\FilamentTests\Stubs\Base;

class CannotRender extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->getToggledHiddenByDefaultColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_TOGGLED_HIDDEN_BY_DEFAULT_COLUMNS' => $this->getToggledHiddenByDefaultColumns($this->resource)->keys(),
        ];
    }
}
