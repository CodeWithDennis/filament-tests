<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Action;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Visible extends Base
{
    public function getDescription(): string
    {
        return 'can render header actions on the index page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource)
            && $this->hasAnyVisibleIndexHeaderAction($this->resource, $this->getIndexHeaderActions($this->resource)['visible']->toArray());
    }

    public function getVariables(): array
    {
        return [
            'INDEX_PAGE_VISIBLE_HEADER_ACTIONS' => $this->convertDoubleQuotedArrayString($this->getIndexHeaderActions($this->resource)['visible']->values()),
        ];
    }
}
