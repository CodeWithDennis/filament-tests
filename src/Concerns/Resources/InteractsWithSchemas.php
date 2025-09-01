<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Infolists\Components\Entry;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

trait InteractsWithSchemas
{
    public function getResourceForm(): Schema
    {
        return $this->getResource()->form(new Schema(
            app('livewire')->new(EditRecord::class)
        ));
    }

    public function getResourceInfolist(): Schema
    {
        return $this->getResource()->infolist(new Schema(
            app('livewire')->new(ViewRecord::class)
        ));
    }

    public function getResourceInfolistFields(): array
    {
        return collect($this->getResourceInfolist()->getFlatComponents(withHidden: true))
            ->whereInstanceOf(Entry::class)
            ->all();
    }

    public function getResourceFormFields(): array
    {
        return $this->getResourceForm()->getFlatFields(true);
    }
}
