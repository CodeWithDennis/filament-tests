<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class CannotRender extends Base
{
    public Closure|string|null $name = 'CannotRender';

    public Closure|string|null $group = 'Page/Index/Table/Columns';

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
