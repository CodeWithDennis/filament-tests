<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Column;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class CannotRender extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'cannot render column on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
