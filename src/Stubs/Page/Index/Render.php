<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure | string | null $name = 'Render';

    public Closure | string | null $group = 'Page/Index';

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource);
    }
}
