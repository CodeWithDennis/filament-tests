<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use Filament\Resources\Resource;

interface HasFilamentResources
{
    public function getResourceClass(): ?string;

    public function getResource() : Resource;
}
