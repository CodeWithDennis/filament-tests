<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\BulkAction;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Delete extends Base
{
    public function getDescription(): string
    {
        return 'can bulk delete records';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && ! $this->hasSoftDeletes($this->resource)
            && $this->hasTableBulkAction('delete', $this->resource);
    }
}
