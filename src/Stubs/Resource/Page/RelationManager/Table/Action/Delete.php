<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Action;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Delete extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can delete records on relation manager';
    }
}
