<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

trait InteractsWithResources
{
    /** @return class-string<resource>|null */
    public function getResourceClass(): ?string
    {
        return $this->resourceClass;
    }

    /** @return class-string<Model>|null */
    public function getResourceModel(): ?string
    {
        /** @var class-string<resource>|null $resource */
        $resource = $this->getResourceClass();

        return $resource ? $resource::getModel() : null;
    }
}
