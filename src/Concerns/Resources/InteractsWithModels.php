<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

trait InteractsWithModels
{
    // TODO: configurable
    public function getAuthenticatableModel(): ?string
    {
        return 'App\Models\User';
    }

    public function getResourceModel(): ?string
    {
        return $this->getResource()->getModel();
    }

    public function getResourceModelName(): ?string
    {
        return str(class_basename($this->getResource()->getModel()))->camel();
    }

    public function getResourceModelNamePlural(): ?string
    {
        return str($this->getResourceModelName())->plural();
    }
}
