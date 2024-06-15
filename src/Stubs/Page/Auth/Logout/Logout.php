<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Auth\Logout;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Logout extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can logout';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: implement
    }
}
