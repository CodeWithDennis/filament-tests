<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\BulkAction;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class DeleteSoft extends Base
{
    public Closure|bool $isTodos = true;

    public function getDescription(): string
    {
        return 'can bulk (soft) delete records on relation manager';
    }
}
