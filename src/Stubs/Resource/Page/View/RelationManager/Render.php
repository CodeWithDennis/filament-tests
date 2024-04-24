<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\RelationManager;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render relation manager on the view page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers(); // TODO: implement
    }
}
