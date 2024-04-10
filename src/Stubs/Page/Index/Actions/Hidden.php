<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Actions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Hidden extends Base
{
    public Closure | string | null $name = 'Hidden';

    public Closure | string | null $group = 'Page/Index/Actions';

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource)
            && $this->hasAnyVisibleIndexHeaderAction($this->resource, $this->getIndexHeaderActions($this->resource)['visible']->toArray());
    }

    public function getVariables(): array
    {
        return [
            'INDEX_PAGE_HIDDEN_HEADER_ACTIONS' => $this->getIndexHeaderActions($this->resource)['hidden']->values(),
        ];
    }
}
