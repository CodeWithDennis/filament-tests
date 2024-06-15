<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Validate extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can validate create form input';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: implement
    }
}
