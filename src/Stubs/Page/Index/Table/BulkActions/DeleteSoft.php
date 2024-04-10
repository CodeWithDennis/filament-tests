<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\BulkActions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class DeleteSoft extends Base
{
    public string $name = 'DeleteSoft';

    public ?string $group = 'Page/Index/Table/BulkActions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableFilter('trashed', $this->getResourceTable($this->resource))
            && $this->hasSoftDeletes($this->resource)
            && $this->hasTableBulkAction('delete', $this->resource);
    }
}
