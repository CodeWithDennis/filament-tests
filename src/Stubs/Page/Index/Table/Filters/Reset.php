<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Filters;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Reset extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->getResourceTableFilters($this->getResourceTable($this->resource))->contains('reset');
    }
}
