<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Column;

use CodeWithDennis\FilamentTests\Stubs\Base;

class CannotRender extends Base
{
    public function getDescription(): string
    {
        return 'cannot render column';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig() &&
            $this->getToggledHiddenByDefaultColumns($this->resource)->isNotEmpty();
    }

    public function getVariables(): array
    {
        return [
            'RESOURCE_TABLE_TOGGLED_HIDDEN_BY_DEFAULT_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getToggledHiddenByDefaultColumns($this->resource)->keys()),
        ];
    }
}
