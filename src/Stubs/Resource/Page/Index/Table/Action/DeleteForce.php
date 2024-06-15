<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Action;

use CodeWithDennis\FilamentTests\Stubs\Base;

class DeleteForce extends Base
{
    public function getDescription(): string
    {
        return 'can force delete records';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && ! $this->hasSoftDeletes($this->resource)
            && $this->hasTableAction('forceDelete', $this->resource);
    }
}
