<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\BulkActions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class ForceDelete extends Base
{
    public string $name = 'ForceDelete';

    public ?string $group = 'Page/Index/Table/BulkActions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && $this->hasSoftDeletes($this->resource)
            && $this->hasTableBulkAction('forceDelete', $this->resource);
    }
}
