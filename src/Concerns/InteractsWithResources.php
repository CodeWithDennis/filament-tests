<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

trait InteractsWithResources
{
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
}
