<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\RelationManager;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Trashed extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'cannot display trashed records by default on the view page on '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: implement
    }
}
