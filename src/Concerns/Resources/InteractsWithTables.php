<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Actions\Action;
use Filament\Infolists\Components\Entry;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

trait InteractsWithTables
{
    public function getResourceTable(): Table
    {
        return $this->getResource()->table(new Table(
            app('livewire')->new(ListRecords::class)
        ));
    }

    public function getResourceTableColumns(): Collection
    {
        return collect($this->getResourceTable()->getColumns());
    }

    public function getResourceVisibleTableColumns(): Collection
    {
        return $this->getResourceTableColumns()
            ->filter(fn (Column $column): bool => $column->isVisible());
    }

    public function getResourceTableVisibleColumnKeys(): array
    {
        return $this->getResourceVisibleTableColumns()
            ->map(fn (Column $column) => $column->getName())
            ->filter()
            ->values()
            ->all();
    }

    public function getResourceHiddenTableColumns(): Collection
    {
        return $this->getResourceTableColumns()
            ->filter(fn (Column $column): bool => $column->isHidden());
    }

    public function getResourceHiddenTableColumnKeys(): array
    {
        return $this->getResourceHiddenTableColumns()
            ->map(fn (Column $column) => $column->getName())
            ->filter()
            ->values()
            ->all();
    }

    public function getResourceSortableTableColumns(): Collection
    {
        return $this->getResourceTableColumns()
            ->filter(fn (Column $column): bool => $column->isSortable());
    }

    public function getResourceTableActions(): array
    {
        return $this->getResourceTable()->getRecordActions();
    }

    public function getResourceTableVisibleActions(): array
    {
        return array_filter($this->getResourceTableActions(), fn (Action $action): bool => ! $this->getPrivateProperty($action, 'isHidden'));
    }
}
