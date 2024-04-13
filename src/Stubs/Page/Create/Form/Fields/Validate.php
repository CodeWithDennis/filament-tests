<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Create\Form\Fields;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Validate extends Base
{
    public Closure|bool $isTodo = true;

    public function getShouldGenerate(): bool
    {
        // TODO: Check for fields with any validation rules
        return true;
    }
}
