<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Edit;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure | string | null $name = 'Render';

    public Closure | string | null $group = 'Page/Edit';

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('edit', $this->resource);
    }
}
