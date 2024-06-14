<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\Infolist\Action;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Exist extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has action on infolist';
    }

    public function getShouldGenerate(): bool
    {
        return true;
    }
}
