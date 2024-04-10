<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Create;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public string $name = 'Render';

    public ?string $group = 'Page/Create';

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('create', $this->resource);
    }
}
