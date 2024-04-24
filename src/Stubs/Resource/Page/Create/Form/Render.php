<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render form on the create page';
    }

    public function getShouldGenerate(): bool
    {
        return true; // TODO: implement
    }
}
