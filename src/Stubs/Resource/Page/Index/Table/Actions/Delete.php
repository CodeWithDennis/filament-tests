<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Actions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Delete extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasTableAction('delete', $this->resource) && ! $this->hasSoftDeletes($this->resource);
    }
}
