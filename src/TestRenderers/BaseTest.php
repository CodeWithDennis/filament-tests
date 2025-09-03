<?php

namespace CodeWithDennis\FilamentTests\TestRenderers;

use CodeWithDennis\FilamentTests\Concerns\ExposesPublicMethodsToViews;
use CodeWithDennis\FilamentTests\Concerns\HasFilamentResources;
use CodeWithDennis\FilamentTests\Concerns\InteractsWithResources;
use CodeWithDennis\FilamentTests\Concerns\Renderers\CanRenderViews;
use Filament\Resources\Resource;

abstract class BaseTest implements HasFilamentResources
{
    use CanRenderViews;
    use ExposesPublicMethodsToViews;
    use InteractsWithResources;

    private bool $tableLoadingDeferred;

    public function __construct(
        public ?string $resourceClass = null,
    ) {}

    public function tableLoadingDeferred(bool $tableLoadingDeferred): static
    {
        $this->tableLoadingDeferred = $tableLoadingDeferred;

        return $this;
    }

    public static function build(string $resourceClass): static
    {
        return new static($resourceClass);
    }

    public function isTableLoadingDeferred(): bool
    {
        return $this->tableLoadingDeferred;
    }

    public function getResourceClass(): ?string
    {
        return $this->resourceClass;
    }

    public function getResource(): Resource
    {
        /** @var class-string<resource> $resourceClass */
        $resourceClass = $this->getResourceClass();

        return new $resourceClass;
    }
}
