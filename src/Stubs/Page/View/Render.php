<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\View;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public string $name = 'Render';

    public ?string $group = 'Page/View';

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('view', $this->resource);
    }
}
