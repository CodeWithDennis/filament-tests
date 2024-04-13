<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Summaries;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Sum extends Base
{
    public Closure|bool $isTodo = true;

    public function getShouldGenerate(): bool
    {
        return true;
//        return $this->getResourceTableColumnsWithSummarizers($this->resource)->isNotEmpty();
    }
}
