<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Actions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Exist extends Base
{
    public string $name = 'Exist';

    public ?string $group = 'Page/Index/Actions';

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('index', $this->resource)
            && $this->hasAnyIndexHeaderAction($this->resource, $this->getIndexHeaderActions($this->resource)['all']->toArray());
    }

    public function getVariables(): array
    {
        return [
            'INDEX_PAGE_HEADER_ACTIONS' => $this->getIndexHeaderActions($this->resource)['all']->values(),
        ];
    }
}
