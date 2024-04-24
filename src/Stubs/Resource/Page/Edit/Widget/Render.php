<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Widget;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getDescription(): string
    {
        return 'can render widget on the edit page';
    }

    public function getShouldGenerate(): bool
    {
        return true; // TODO: implement
    }
}
