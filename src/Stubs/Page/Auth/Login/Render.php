<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Auth\Login;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getDescription(): string
    {
        return 'can render the login page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasLogin()
            && $this->getPanelPath()
            && $this->getLoginRouteAction();
    }

    public function getVariables(): array
    {
        return [
            'PANEL_PATH' => str($this->getPanelPath())->wrap('\''),
            'LOGIN_ROUTE_ACTION' => str($this->getLoginRouteAction())->prepend('\\'),
        ];
    }
}
