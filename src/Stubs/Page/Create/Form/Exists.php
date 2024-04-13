<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Create\Form;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Exists extends Base
{
    public Closure|bool $isTodo = true;

    public function getShouldGenerate(): bool
    {
        return true;
    }
}
