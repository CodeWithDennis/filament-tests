<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class ListRecords extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource);
    }
}
