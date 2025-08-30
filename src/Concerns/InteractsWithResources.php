<?php

namespace CodeWithDennis\FilamentTests\Concerns;

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
}
