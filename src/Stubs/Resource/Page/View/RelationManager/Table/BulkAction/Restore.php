<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\RelationManager\Table\BulkAction;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Restore extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can bulk restore records on the view page on '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: Implement
    }
}
