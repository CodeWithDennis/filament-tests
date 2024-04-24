<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Render extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can render form on the edit page';
    }

    public function getShouldGenerate(): bool
    {
        return true; // TODO: implement
    }
}
