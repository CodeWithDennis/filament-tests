<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Actions\Action;
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

    public function getResourceTableColumnKeys(): array
    {
        return $this->getResourceTableColumns()
            ->map(fn (Column $column): string => $column->getName())
            ->filter()
            ->values()
            ->all();
    }

    public function getResourceInitiallyVisibleTableColumns(): Collection
    {
        return $this->getResourceTableColumns()
            ->filter(fn (Column $column): bool => $column->isVisible() && ! $column->isToggledHiddenByDefault());
    }

    public function getResourceInitiallyVisibleTableColumnKeys(): array
    {
        return $this->getResourceInitiallyVisibleTableColumns()
            ->map(fn (Column $column): string => $column->getName())
            ->filter()
            ->values()
            ->all();
    }

    public function getResourceInitiallyHiddenTableColumns(): Collection
    {
        return $this->getResourceTableColumns()
            ->filter(fn (Column $column): bool => ! $column->isVisible() || $column->isToggledHiddenByDefault());
    }

    public function getResourceInitiallyHiddenTableColumnKeys(): array
    {
        return $this->getResourceInitiallyHiddenTableColumns()
            ->map(fn (Column $column): string => $column->getName())
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
