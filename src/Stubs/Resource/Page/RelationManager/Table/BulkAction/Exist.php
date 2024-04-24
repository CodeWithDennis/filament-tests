<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\BulkAction;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Exist extends Base
{
    public Closure|bool $isTodos = true;

    public function getDescription(): string
    {
        return 'has table bulk action on relation manager';
    }
}
