<?php

namespace CodeWithDennis\FilamentTests\Concerns;

trait InteractsWithResources
{
    public ?string $resourceClass = null;

    public function getResourceClass(): ?string
    {
        return $this->resourceClass;
    }
}
