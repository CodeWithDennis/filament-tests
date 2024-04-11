<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\View;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasPage('view', $this->resource);
    }
}
