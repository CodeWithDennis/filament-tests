<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Filters;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Reset extends Base
{
    public Closure|string|null $name = 'Reset';

    public Closure|string|null $group = 'Page/Index/Table/Filters';

    public function getShouldGenerate(): bool
    {
        return $this->getResourceTableFilters($this->getResourceTable($this->resource))->contains('reset');
    }
}
