<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Action;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Exist extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has header actions on the index page on relation manager';
    }
}
