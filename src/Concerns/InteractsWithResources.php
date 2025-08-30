<?php

namespace CodeWithDennis\FilamentTests\Concerns;

trait InteractsWithResources
{
    public function getResourceClass(): ?string
    {
        return $this->resourceClass;
    }
}
