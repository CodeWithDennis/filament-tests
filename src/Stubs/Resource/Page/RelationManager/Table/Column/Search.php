<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Column;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Search extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can search column on relation manager';
    }
}
