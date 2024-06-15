<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Action;

use CodeWithDennis\FilamentTests\Stubs\Base;

class UrlTab extends Base
{
    public function getDescription(): string
    {
        return 'has the correct URL and opens in a new tab for table action';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->hasTableActionWithUrlThatShouldOpenInNewTab($this->resource);
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_ACTIONS_WITH_URL_THAT_SHOULD_OPEN_IN_NEW_TAB' => $this->transformToPestDataset($this->getTableActionsWithUrlThatShouldOpenInNewTabValues($this->resource), ['name', 'url']),
        ];
    }
}
