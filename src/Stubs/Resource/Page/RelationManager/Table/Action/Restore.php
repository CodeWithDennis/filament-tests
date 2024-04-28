<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Action;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Restore extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can restore records on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
