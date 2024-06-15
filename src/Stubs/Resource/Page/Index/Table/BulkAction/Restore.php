<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\BulkAction;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Restore extends Base
{
    public function getDescription(): string
    {
        return 'can bulk restore records';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && $this->hasSoftDeletes($this->resource)
            && $this->hasTableBulkAction('restore', $this->resource);
    }
}
