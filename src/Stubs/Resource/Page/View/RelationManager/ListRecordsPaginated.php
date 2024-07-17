<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\RelationManager;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class ListRecordsPaginated extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can list records on the '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager on the view page with pagination';
    }

    public function getShouldGenerate(): bool
    {
        return false; // @see https://github.com/CodeWithDennis/filament-tests/issues/258
//        return false && $this->getGroupToConfig();
        //        return $this->hasPage('view', $this->resource)
        //            && $this->hasRelationManager($this->relationManager) &&
        //            $this->getRelationManagerTableColumns($this->relationManager)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'DEFAULT_PER_PAGE_OPTION' => $this->convertDoubleQuotedArrayString($this->getTableDefaultPaginationPageOption($this->resource)),
            'DEFAULT_PAGINATED_RECORDS_FACTORY_COUNT' => $this->convertDoubleQuotedArrayString($this->getTableDefaultPaginationPageOption($this->resource) * 2),
            'RELATION_MANAGER_NAME' => str($this->relationManager)->basename(),
            'RELATION_MANAGER_CLASS' => $this->relationManager.'::class',
            'RELATION_MANAGER_RELATIONSHIP_MODEL' => $this->getRelationManagerRelationshipNameToModelClass($this->relationManager),
            'RELATION_MANAGER_RELATIONSHIP_NAME_UCFIRST' => str($this->getRelationManager($this->relationManager)->getRelationshipName())->ucfirst(),
            'RELATION_MANAGER_RELATIONSHIP_NAME_LCFIRST' => str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst(),
        ];
    }
}
