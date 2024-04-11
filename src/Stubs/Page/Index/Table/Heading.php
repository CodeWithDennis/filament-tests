<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Heading extends Base
{
    public Closure|string|null $name = 'Heading';

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource)
            && $this->tableHasHeading($this->resource);
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_HEADING' => str($this->getTableHeading($this->resource))->wrap('\''),
        ];
    }
}
