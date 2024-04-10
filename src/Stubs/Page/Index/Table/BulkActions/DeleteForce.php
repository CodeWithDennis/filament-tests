<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\BulkActions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class DeleteForce extends Base
{
    public Closure | string | null $name = 'DeleteForce';

    public Closure | string | null $group = 'Page/Index/Table/BulkActions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && $this->hasSoftDeletes($this->resource)
            && $this->hasTableBulkAction('forceDelete', $this->resource);
    }
}
