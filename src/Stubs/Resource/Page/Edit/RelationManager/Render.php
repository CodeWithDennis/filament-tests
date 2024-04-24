<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\RelationManager;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render relation manager on the edit page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers(); // TODO: implement
    }
}
