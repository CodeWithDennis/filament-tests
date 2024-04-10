<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Replicate extends Base
{
    public Closure | string | null $name = 'Replicate';

    public Closure | string | null $group = 'Page/Index/Table/Actions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableAction('replicate', $this->resource);
    }
}
