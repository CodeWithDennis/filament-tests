<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\RelationManager\Table\Column;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getDescription(): string
    {
        return 'can render column on the '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager on the edit page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasPage('edit', $this->resource)
            && $this->getRelationManagerTableColumns($this->relationManager)->isNotEmpty()
            && $this->getRelationManagerToggledHiddenByDefaultColumns($this->relationManager)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RELATION_MANAGER_NAME' => str($this->relationManager)->basename(),
            'RELATION_MANAGER_CLASS' => $this->relationManager.'::class',
            'RELATION_MANAGER_RELATIONSHIP_MODEL' => $this->getRelationManagerRelationshipNameToModelClass($this->relationManager),
            'RELATION_MANAGER_RELATIONSHIP_NAME' => str($this->getRelationManager($this->relationManager)->getRelationshipName())->ucfirst(),
            'RELATION_MANAGER_TABLE_INITIALLY_VISIBLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getRelationManagerInitiallyVisibleColumns($this->relationManager)->keys()),
        ];
    }
}
