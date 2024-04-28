<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Action;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Hidden extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'cannot render header actions on the index page on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
