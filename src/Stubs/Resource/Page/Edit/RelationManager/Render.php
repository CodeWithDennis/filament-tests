<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\RelationManager;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getDescription(): string
    {
        return 'can render '.str($this->relationManager)->basename().' on the edit page.';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getRelationManagerTableColumns($this->relationManager)->isNotEmpty();
    }

    public function getVariables(): array
    {
        $relationManagerNamespace = str($this->relationManager)->beforeLast('\\')->prepend('\\');
        $relationManagerName = str($this->relationManager)->basename();

        return [
            'RELATION_MANAGER_NAME' => $relationManagerName,
            'RELATION_MANAGER_CLASS' => $relationManagerNamespace.'\\'.$relationManagerName->append('::class'),
            'RELATION_MANAGER_RELATIONSHIP_MODEL' => $this->getRelationManagerRelationshipNameToModelClass($this->relationManager),
            'RELATION_MANAGER_RELATIONSHIP_NAME' => str($this->getRelationManager($this->relationManager)->getRelationshipName())->ucfirst(),
        ];
    }
}
