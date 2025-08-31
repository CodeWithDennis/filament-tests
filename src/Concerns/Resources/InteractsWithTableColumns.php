<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Tables\Columns\Column;

trait InteractsWithTableColumns
{
    public function getResourceTableColumns(): array
    {
        return $this->getResourceTable()->getColumns();
    }

    public function getResourceSortableTableColumns(): array
    {
        return array_filter($this->getResourceTableColumns(), fn (Column $column) => $column->isSortable());
    }
}
