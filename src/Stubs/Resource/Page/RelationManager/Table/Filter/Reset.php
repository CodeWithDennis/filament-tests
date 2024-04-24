<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\RelationManager\Table\Filter;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Reset extends Base
{
    public function getDescription(): string
    {
        return 'can reset table filters on relation manager';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManagers();
    }
}
