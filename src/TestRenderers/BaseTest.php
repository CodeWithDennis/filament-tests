<?php

namespace CodeWithDennis\FilamentTests\TestRenderers;

abstract class BaseTest
{
    protected ?string $resourceClass = null;

    public static function build(string $resourceClass): static
    {
        return new static($resourceClass);
    }

    public function __construct(string $resourceClass)
    {
        $this->resourceClass = $resourceClass;
    }

    protected function getResourceClass(): ?string
    {
        return $this->resourceClass;
    }

    abstract public function render(): string;
}
