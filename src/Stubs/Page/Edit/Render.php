<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Edit;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasPage('edit', $this->resource);
    }
}
