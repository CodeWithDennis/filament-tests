<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class DeleteForce extends Base
{
    public string $name = 'DeleteForce';

    public ?string $group = 'Page/Index/Table/Actions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && ! $this->hasSoftDeletes($this->resource)
            && $this->hasTableAction('forceDelete', $this->resource);
    }
}
