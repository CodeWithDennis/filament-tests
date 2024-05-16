<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\RelationManager\Table\Column;

use CodeWithDennis\FilamentTests\Stubs\Base;

class DescriptionAbove extends Base
{
    public function getDescription(): string
    {
        return 'has the correct descriptions (above) on the '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager on the view page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('view', $this->resource)
            && $this->getRelationManagerTableColumns($this->relationManager)->isNotEmpty()
            && $this->getRelationManagerDescriptionAboveColumns($this->relationManager)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RELATION_MANAGER_NAME' => str($this->relationManager)->basename(),
            'RELATION_MANAGER_CLASS' => $this->relationManager.'::class',
            'RELATION_MANAGER_RELATIONSHIP_MODEL' => $this->getRelationManagerRelationshipNameToModelClass($this->relationManager),
            'RELATION_MANAGER_RELATIONSHIP_NAME' => str($this->getRelationManager($this->relationManager)->getRelationshipName())->ucfirst(),
            'RELATION_MANAGER_TABLE_DESCRIPTIONS_ABOVE_COLUMNS' => $this->transformToPestDataset($this->getRelationManagerTableColumnDescriptionAbove($this->relationManager), ['column', 'description']),
        ];
    }
}
