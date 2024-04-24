<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Trashed extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'cannot display trashed records by default on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
