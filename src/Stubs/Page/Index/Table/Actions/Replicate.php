<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Replicate extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasTableAction('replicate', $this->resource);
    }
}
