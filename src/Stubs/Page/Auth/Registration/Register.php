<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Auth\Registration;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Register extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can register';
    }

    public function getShouldGenerate(): bool
    {
        return true;
    }
}
