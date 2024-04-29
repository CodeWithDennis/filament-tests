<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\RelationManager\Table;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Heading extends Base
{
    public function getDescription(): string
    {
        return 'has the correct table heading on the '. str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst() .' relation manager on the edit page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRelationManager($this->relationManager)
            && $this->relationManagerHasTableHeading($this->relationManager);
    }

    public function getVariables(): array
    {
        return [
            'RELATION_MANAGER_CLASS' => $this->relationManager.'::class',
            'RELATION_MANAGER_TABLE_HEADING' => $this->convertDoubleQuotedArrayString(str($this->getRelationManagerTableHeading($this->relationManager))->wrap('\'')),
        ];
    }
}
