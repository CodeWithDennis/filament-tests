<?php

namespace CodeWithDennis\FilamentTests\Stubs;

use Closure;

class SetupStub extends Base
{
    public Closure|string|null $name = 'Setup';

    public function getShouldGenerate(): bool
    {
        if ($this->hasTenancy()) {
            return false;
        }

        return true;
    }
}
