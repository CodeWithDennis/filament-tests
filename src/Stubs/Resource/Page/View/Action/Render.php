<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\Action;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render action on the view page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: Implement
    }
}
