<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\RelationManager\Table\Filter;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Reset extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can reset a table filter on the '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager on the view page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasPage('view', $this->resource)
            && $this->getRelationManagerTableFilters($this->relationManager)->isNotEmpty();
    }
}
