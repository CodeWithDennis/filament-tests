<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\BulkAction;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Delete extends Base
{
    public Closure|bool $isTodos = true;

    public function getDescription(): string
    {
        return 'can bulk delete records on relation manager';
    }
}
