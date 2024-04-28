<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Field;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Validate extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can validate input on create form';
    }

    public function getShouldGenerate(): bool
    {
        // TODO: Implement getShouldGenerate() logic
        return true;
    }
}
