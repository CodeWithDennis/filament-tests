<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Custom\RelationManager;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render relation manager on page X';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasCustomPages(); // TODO: implement
    }
}
