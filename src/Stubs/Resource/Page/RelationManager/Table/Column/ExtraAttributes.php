<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Column;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class ExtraAttributes extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has extra attributes on relation manager';
    }
}
