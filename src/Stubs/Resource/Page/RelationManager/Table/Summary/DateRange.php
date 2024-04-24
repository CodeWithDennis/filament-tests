<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Summary;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;
use ReflectionClass;

class DateRange extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can range date values in a column on relation manager';
    }
}
