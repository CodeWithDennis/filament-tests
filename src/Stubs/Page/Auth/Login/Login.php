<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Auth\Login;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Login extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can login';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: implement
    }
}
