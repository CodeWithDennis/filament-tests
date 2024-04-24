<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\Action;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getDescription(): string
    {
        return 'can render action on the view page';
    }

    public function getShouldGenerate(): bool
    {
        return true; // TODO: implement
    }
}
