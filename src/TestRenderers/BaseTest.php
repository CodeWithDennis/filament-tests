<?php

namespace CodeWithDennis\FilamentTests\TestRenderers;

use CodeWithDennis\FilamentTests\Concerns\InteractsWithResources;

abstract class BaseTest
{
    use InteractsWithResources;

    public ?string $view = null;

    public function __construct(
        public ?string $resourceClass = null,
    ) {}

    public static function build(string $resourceClass): static
    {
        return new static($resourceClass);
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
