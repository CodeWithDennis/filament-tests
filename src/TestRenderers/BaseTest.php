<?php

namespace CodeWithDennis\FilamentTests\TestRenderers;

use CodeWithDennis\FilamentTests\Concerns\ExposesPublicMethodsToViews;
use CodeWithDennis\FilamentTests\Concerns\HasFilamentResources;
use CodeWithDennis\FilamentTests\Concerns\InteractsWithResources;
use CodeWithDennis\FilamentTests\Concerns\Renderers\CanBeTodo;

abstract class BaseTest implements HasFilamentResources
{
    use CanBeTodo;
    use CanRenderViews;
    use ExposesPublicMethodsToViews;
    use InteractsWithResources;

    public function __construct(
        public ?string $resourceClass = null,
    ) {}

    public static function build(string $resourceClass): static
    {
        return new static($resourceClass);
    }

    public function getResourceClass(): ?string
    {
        return $this->resourceClass;
    }

    public function getResource()
    {
        return new ($this->getResourceClass());
    }
}
