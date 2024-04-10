<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\BulkActions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Restore extends Base
{
    public Closure | string | null $name = 'Restore';

    public Closure | string | null $group = 'Page/Index/Table/BulkActions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && $this->hasSoftDeletes($this->resource)
            && $this->hasTableBulkAction('restore', $this->resource);
    }
}
