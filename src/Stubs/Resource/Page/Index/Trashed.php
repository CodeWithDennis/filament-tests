<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Trashed extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasSoftDeletes($this->resource) && $this->getTableColumns($this->resource)->isNotEmpty();
    }
}
