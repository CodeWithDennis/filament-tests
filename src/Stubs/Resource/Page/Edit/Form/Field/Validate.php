<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Field;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Validate extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can validate input on edit form';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: Implement
    }
}
