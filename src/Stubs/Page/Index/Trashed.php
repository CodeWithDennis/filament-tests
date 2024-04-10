<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Trashed extends Base
{
    public string $name = 'Trashed';

    public ?string $group = 'Page/Index';

    public function getShouldGenerate(): bool
    {
        return $this->hasSoftDeletes($this->resource) && $this->getTableColumns($this->resource)->isNotEmpty();
    }
}
