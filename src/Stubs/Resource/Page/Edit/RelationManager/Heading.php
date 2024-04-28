<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\RelationManager;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Heading extends Base
{
    public function getDescription(): string
    {
        return 'has the correct table heading on the '.str($this->relationManager)->basename()->snake()->replace('_', ' ').' on the edit page';
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
