<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\RelationManager\Table\Filter;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Add extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can add a table filter on the '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager on the edit page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasPage('edit', $this->resource)
            && $this->getRelationManagerTableFilters($this->relationManager)->isNotEmpty();
    }
}
