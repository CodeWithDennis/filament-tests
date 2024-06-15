<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Widget;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class RenderHeaderWidgets extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render header widgets on the index page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: implement
    }
}
