<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class UrlTab extends Base
{
    public Closure | string | null $name = 'UrlTab';

    public Closure | string | null $group = 'Page/Index/Table/Actions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableActionWithUrlThatShouldOpenInNewTab($this->resource);
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_ACTIONS_WITH_URL_THAT_SHOULD_OPEN_IN_NEW_TAB' => $this->transformToPestDataset($this->getTableActionsWithUrlThatShouldOpenInNewTabValues($this->resource), ['name', 'url']),
        ];
    }
}
