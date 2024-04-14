<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Create\Form;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Validate extends Base
{
    public Closure|bool $isTodo = true;

    public function getShouldGenerate(): bool
    {
        // TODO: Implement getShouldGenerate() logic
        return true;
    }
}
