<?php

namespace CodeWithDennis\FilamentTests\TestRenderers;

use CodeWithDennis\FilamentTests\Concerns\InteractsWithResources;

abstract class BaseTest
{
    public ?string $view = null;

    use InteractsWithResources;

    public function __construct(
        public ?string $resourceClass = null,
    ) {}

    public static function build(string $resourceClass, ?string $view = null): static
    {
        return new static($resourceClass, $view);
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
            'resourceModel' => $this->getResourceModel(),
        ])->render();
    }
}
