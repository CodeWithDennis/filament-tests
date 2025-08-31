<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use ReflectionClass;

trait InteractsWithResources
{
    protected function getPrivateProperty(object $object, string $property): mixed
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    public function getResourceClass(): ?string
    {
        return $this->resourceClass;
    }

    public function getResource()
    {
        return new ($this->getResourceClass());
    }

    public function getResourceModel(): ?string
    {
        return $this->getResource()->getModel();
    }

    public function getResourceForm()
    {
        return $this->getResource()->form(new Schema);
    }

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

    public function getResourceTableActions(): array
    {
        return $this->getResourceTable()->getActions();
    }

    public function getResourceTableVisibleActions(): array
    {
        return array_filter($this->getResourceTableActions(), fn (Action $action): bool => ! $this->getPrivateProperty($action, 'isHidden'));
    }

    public function getResourceSortableTableColumns(): array
    {
        return array_filter($this->getResourceTableColumns(), fn (Column $column): bool => $column->isSortable());
    }
}
