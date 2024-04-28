<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\RelationManager\Filter;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Reset extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can reset a table filter on the '.str($this->relationManager)->basename()->snake()->replace('_', ' ').' on the edit page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getRelationManagerTableFilters($this->relationManager)->isNotEmpty();
    }
}
