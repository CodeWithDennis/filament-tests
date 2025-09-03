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

    private function getResourceTableColumnKeysFrom(Collection $columns): array
    {
        return $columns
            ->map(fn (Column $column): string => $column->getName())
            ->filter()
            ->values()
            ->all();
    }

    public function getResourceTableColumns(): Collection
    {
        return collect($this->getResourceTable()->getColumns());
    }

    public function getResourceTableColumnKeys(): array
    {
        return $this->getResourceTableColumnKeysFrom($this->getResourceTableColumns());
    }

    public function getResourceTableDefaultVisibleColumns(): Collection
    {
        return $this->getResourceTableColumns()
            ->filter(fn (Column $column): bool => $column->isVisible() && ! $column->isToggledHiddenByDefault());
    }

    public function getResourceTableDefaultVisibleColumnKeys(): array
    {
        return $this->getResourceTableColumnKeysFrom($this->getResourceTableDefaultVisibleColumns());
    }

    public function getResourceTableDefaultHiddenColumns(): Collection
    {
        return $this->getResourceTableColumns()
            ->filter(fn (Column $column): bool => ! $column->isVisible() || $column->isToggledHiddenByDefault());
    }

    public function getResourceTableDefaultHiddenColumnKeys(): array
    {
        return $this->getResourceTableColumnKeysFrom($this->getResourceTableDefaultHiddenColumns());
    }

    public function getResourceTableVisibleColumns(): Collection
    {
        return $this->getResourceTableColumns()
            ->filter(fn (Column $column): bool => $column->isVisible());
    }

    public function getResourceTableVisibleColumnKeys(): array
    {
        return $this->getResourceTableColumnKeysFrom($this->getResourceTableVisibleColumns());
    }

    public function getResourceTableHiddenColumns(): Collection
    {
        return $this->getResourceTableColumns()
            ->filter(fn (Column $column): bool => $column->isHidden());
    }

    public function getResourceTableHiddenColumnKeys(): array
    {
        return $this->getResourceTableColumnKeysFrom($this->getResourceTableHiddenColumns());
    }

    public function getResourceTableSortableColumns(): Collection
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
