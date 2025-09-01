<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;

trait InteractsWithTables
{
    public function getResourceTable()
    {
        return $this->getResource()->table(new Table(
            app('livewire')->new(ListRecords::class)
        ));
    }

    public function getResourceTableColumns(): array
    {
        return $this->getResourceTable()->getColumns();
    }

    public function getResourceSortableTableColumns(): array
    {
        return array_filter($this->getResourceTableColumns(), fn (Column $column): bool => $column->isSortable());
    }

    public function getResourceTableActions(): array
    {
        return $this->getResourceTable()->getActions();
    }

    public function getResourceTableVisibleActions(): array
    {
        return array_filter($this->getResourceTableActions(), fn (Action $action): bool => ! $this->getPrivateProperty($action, 'isHidden'));
    }
}
