<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Column;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class SearchIndividually extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can individually search by column on relation manager';
    }
}
