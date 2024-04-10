<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions;

use CodeWithDennis\FilamentTests\Stubs\Base;

class Replicate extends Base
{
    public string $name = 'Replicate';

    public ?string $group = 'Page/Index/Table/Actions';

    public function getShouldGenerate(): bool
    {
        return $this->hasTableAction('replicate', $this->resource);
    }
}
