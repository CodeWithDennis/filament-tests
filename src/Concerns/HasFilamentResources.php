<?php

namespace CodeWithDennis\FilamentTests\Concerns;

interface HasFilamentResources
{
    public function getResourceClass(): ?string;

    public function getResource();
}
