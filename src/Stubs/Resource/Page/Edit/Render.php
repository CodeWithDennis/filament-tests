<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render the edit page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('edit', $this->resource);
    }
}
