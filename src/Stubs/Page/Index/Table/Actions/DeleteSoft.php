<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class DeleteSoft extends Base
{
    public Closure | string | null $name = 'DeleteSoft';

    public Closure | string | null $group = 'Page/Index/Table/Actions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableAction('delete', $this->resource) && $this->hasSoftDeletes($this->resource);
    }
}
