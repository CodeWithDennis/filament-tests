<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Actions\Action;

trait InteractsWithTableActions
{
    public function getResourceTableActions(): array
    {
        return $this->getResourceTable()->getActions();
    }

    public function getResourceTableVisibleActions(): array
    {
        return array_filter($this->getResourceTableActions(), fn(Action $action): bool => ! $this->getPrivateProperty($action, 'isHidden'));
    }
}
