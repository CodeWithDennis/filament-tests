<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Description extends Base
{
    public string $name = 'Description';

    public ?string $group = 'Page/Index/Table';

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource)
            && $this->tableHasDescription($this->resource);
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_DESCRIPTION' => str($this->getTableDescription($this->resource))->wrap('\''),
        ];
    }
}
