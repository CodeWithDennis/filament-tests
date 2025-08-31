<?php

namespace CodeWithDennis\FilamentTests\Concerns\Renderers;

trait CanBeDiscovered
{
    public bool $isDiscoverable = true;

    public function isDiscoverable(): bool
    {
        return $this->isDiscoverable;
    }
}
