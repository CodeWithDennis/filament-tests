<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Trashed extends Base
{
    public Closure | string | null $name = 'Trashed';

    public Closure | string | null $group = 'Page/Index';

    public function getShouldGenerate(): bool
    {
        return $this->hasSoftDeletes($this->resource) && $this->getTableColumns($this->resource)->isNotEmpty();
    }
}
