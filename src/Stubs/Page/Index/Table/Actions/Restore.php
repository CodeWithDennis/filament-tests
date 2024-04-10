<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Restore extends Base
{
    public string $name = 'Restore';

    public ?string $group = 'Page/Index/Table/Actions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && $this->hasSoftDeletes($this->resource)
            && $this->hasTableAction('restore', $this->resource);
    }
}
