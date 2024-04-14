<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasPage('create', $this->resource);
    }
}
