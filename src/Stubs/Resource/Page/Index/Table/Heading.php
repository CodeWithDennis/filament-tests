<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Heading extends Base
{
    public function getDescription(): string
    {
        return 'has the correct table heading';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasPage('index', $this->resource)
            && $this->tableHasHeading($this->resource);
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_HEADING' => $this->convertDoubleQuotedArrayString(str($this->getTableHeading($this->resource))->wrap('\'')),
        ];
    }
}
