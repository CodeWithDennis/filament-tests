<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use Closure;

interface HasPath
{
    public function path(string $path): static;

    public function getPath(): string;
}
