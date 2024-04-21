<?php

namespace CodeWithDennis\FilamentTests\Stubs\Pages\Auth\PasswordReset;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getDescription(): string
    {
        return 'can render the reset password page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasPasswordReset()
            && $this->getRequestPasswordResetRouteAction();
    }

    public function getVariables(): array
    {
        return [
            'RESET_PASSWORD_ROUTE_ACTION' => str($this->getRequestPasswordResetRouteAction())->prepend('\\'),
        ];
    }
}
