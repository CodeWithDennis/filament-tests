<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use Filament\Schemas\Schema;

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
}
