<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Filter;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Add extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can add a table filter on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
