<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\Infolist;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render infolist on the view page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasInfolists(); // TODO: implement
    }
}
