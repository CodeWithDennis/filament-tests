<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Action;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Delete extends Base
{
    public function getDescription(): string
    {
        return 'can delete records';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasTableAction('delete', $this->resource) && ! $this->hasSoftDeletes($this->resource);
    }
}
