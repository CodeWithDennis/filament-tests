<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Auth\Registration;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getDescription(): string
    {
        return 'can render the registration page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasRegistration()
            && $this->getRegistrationRouteAction();
    }

    public function getVariables(): array
    {
        return [
            'REGISTRATION_ROUTE_ACTION' => str($this->getRegistrationRouteAction())->prepend('\\'),
        ];
    }
}
