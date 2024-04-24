<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Column;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class State extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has state';
    }

    public function getShouldGenerate(): bool
    {
        return false; // TODO: implement
    }
}
