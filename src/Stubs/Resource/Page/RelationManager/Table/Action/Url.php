<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Action;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Url extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has the correct URL for table action on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
