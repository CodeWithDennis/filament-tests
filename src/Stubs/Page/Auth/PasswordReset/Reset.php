<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Auth\PasswordReset;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Reset extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can reset the password';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: implement
    }
}
