<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Actions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Hidden extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource)
            && $this->hasAnyHiddenIndexHeaderAction($this->resource, $this->getIndexHeaderActions($this->resource)['hidden']->toArray());
    }

    public function getVariables(): array
    {
        return [
            'INDEX_PAGE_HIDDEN_HEADER_ACTIONS' => $this->convertDoubleQuotedArrayString($this->getIndexHeaderActions($this->resource)['hidden']->values()),
        ];
    }
}
