<?php

namespace CodeWithDennis\FilamentTests\TestRenderers;

abstract class BaseTest
{
    //    use \CodeWithDennis\FilamentTests\Concerns\InteractsWithResources;

    public function __construct(
        public ?string $resourceClass = null,
        public ?string $view = null
    ) {}

    public static function build(string $resourceClass, ?string $view = null): static
    {
        return new static($resourceClass, $view);
    }

    public function getResourceClass(): ?string
    {
        return $this->resourceClass;
    }

    public function view(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function render(): string
    {
        return view($this->view, [
            'resourceClass' => $this->getResourceClass(),
        ])->render();
    }
}
