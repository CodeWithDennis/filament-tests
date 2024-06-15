<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\Widget;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class RenderFooterWidgets extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render footer widgets on the view page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getGroupToConfig(); // TODO: implement
    }
}
