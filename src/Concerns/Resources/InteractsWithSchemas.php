<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Schemas\Schema;

trait InteractsWithSchemas
{
    public function getResourceForm(): Schema
    {
        return $this->getResource()->form(new Schema);
    }

    public function getResourceInfolist(): Schema
    {
        return $this->getResource()->infolist(new Schema);
    }

    public function getResourceInfolistFields(): array
    {
        return $this->getResourceInfolist()->getFlatFields();
    }

    public function getResourceFormFields(): array
    {
        return $this->getResourceForm()->getFlatFields();
    }
}
