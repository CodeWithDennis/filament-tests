<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Heading extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has the correct table heading on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
