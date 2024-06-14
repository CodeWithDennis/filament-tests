<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\HeaderAction;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render action on the create page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: Implement
    }
}
