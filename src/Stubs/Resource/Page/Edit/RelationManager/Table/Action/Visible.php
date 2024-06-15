<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\RelationManager\Table\Action;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Visible extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render action on the edit page on '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: Implement
    }
}
