<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\BulkActions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Delete extends Base
{
    public string $name = 'Delete';

    public ?string $group = 'Page/Index/Table/BulkActions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && ! $this->hasSoftDeletes($this->resource)
            && $this->hasTableBulkAction('delete', $this->resource);
    }
}
