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

    public bool $tableLoadingGloballyDeferred = false;

    public function __construct(
        public ?string $resourceClass = null,
    ) {}

    public function tableLoadingGloballyDeferred(bool $tableLoadingGloballyDeferred): static
    {
        $this->tableLoadingGloballyDeferred = $tableLoadingGloballyDeferred;

        return $this;
    }

    public static function build(string $resourceClass): static
    {
        return new static($resourceClass);
    }

    public function isTableLoadingGlobalyDeferred(): bool
    {
        return $this->tableLoadingGloballyDeferred;
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
