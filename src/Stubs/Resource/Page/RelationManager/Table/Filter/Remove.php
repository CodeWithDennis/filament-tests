<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Filter;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Remove extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can remove a table filter on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
