<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Schemas\Schema;

trait InteractsWithForms
{
    public function getResourceForm()
    {
        return $this->getResource()->form(new Schema);
    }
}
