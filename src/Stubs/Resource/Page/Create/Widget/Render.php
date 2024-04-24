<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Widget;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public function getDescription(): string
    {
        return 'can render widget on the create page';
    }

    public function getShouldGenerate(): bool
    {
        return true; // TODO: implement
    }
}
