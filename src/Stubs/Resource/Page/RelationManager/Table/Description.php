<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Description extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has the correct table description on relation manager';
    }
}
