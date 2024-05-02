<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\RelationManager\Table;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Description extends Base
{
    public function getDescription(): string
    {
        return 'has the correct table description on the '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager on the view page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('view', $this->resource)
            && $this->hasRelationManager($this->relationManager)
            && $this->relationManagerHasTableDescription($this->relationManager);
    }

    public function getVariables(): array
    {
        return [
            'RELATION_MANAGER_CLASS' => $this->relationManager.'::class',
            'RELATION_MANAGER_TABLE_DESCRIPTION' => $this->convertDoubleQuotedArrayString(str($this->getRelationManagerTableDescription($this->relationManager))->wrap('\'')),
        ];
    }
}
