<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Heading extends Base
{
    public string $name = 'Heading';

    public ?string $group = 'Page/Index/Table';

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
