<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use Closure;

interface HasPath
{
    /**
     * Get the path to the .stub file relative to the /stubs root.
     */
    //    public function path(string | Closure | null $path): string;
    public function getRelativePath(): string;
}
