<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class ListRecords extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can list records on the index page on relation manager';
    }
}
