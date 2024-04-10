<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Delete extends Base
{
    public string $name = 'Delete';

    public ?string $group = 'Page/Index/Table/Actions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableAction('delete', $this->resource) && ! $this->hasSoftDeletes($this->resource);
    }
}
