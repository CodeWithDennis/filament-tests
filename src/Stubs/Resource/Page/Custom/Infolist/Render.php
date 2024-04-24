<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Custom\Infolist;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render infolist on page X';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasCustomPages(); // TODO: implement
    }
}
