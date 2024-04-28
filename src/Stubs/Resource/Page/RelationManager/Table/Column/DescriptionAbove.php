<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Column;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class DescriptionAbove extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'has the correct descriptions above on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
