<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Action;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Replicate extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can replicate records on relation manager';
    }
}
