<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Actions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Visible extends Base
{
    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource)
            && $this->hasAnyVisibleIndexHeaderAction($this->resource, $this->getIndexHeaderActions($this->resource)['visible']->toArray());
    }

    public function getVariables(): array
    {
        return [
            'INDEX_PAGE_VISIBLE_HEADER_ACTIONS' => $this->getIndexHeaderActions($this->resource)['visible']->values(),
        ];
    }
}
