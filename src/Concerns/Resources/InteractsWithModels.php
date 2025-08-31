<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

trait InteractsWithModels
{
    public function getResourceModel(): ?string
    {
        return $this->getResource()->getModel();
    }
}
