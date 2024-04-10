<?php

namespace CodeWithDennis\FilamentTests\Concerns;

interface HasPath
{
    public function path(string $path): static;

    public function getPath(): string;
}
