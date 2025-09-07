<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

trait InteractsWithModels
{
    public function getResourceModel(): ?string
    {
        return $this->getResource()->getModel();
    }

    public function resourceModelHasSoftDeletes(): bool
    {
        $modelClass = $this->getResourceModel();

        if (! $modelClass) {
            return false;
        }

        return method_exists($modelClass, 'bootSoftDeletes');
    }
}
