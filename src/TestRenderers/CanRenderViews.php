<?php

namespace CodeWithDennis\FilamentTests\TestRenderers;

use Illuminate\Support\Traits\Conditionable;

trait CanRenderViews
{
    use Conditionable;

    public ?string $view = null;

    public bool $shouldRender = true;

    public function view(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function getView(): ?string
    {
        return $this->view;
    }

    public function shouldRender(): static
    {
        $this->shouldRender = true;

        return $this;
    }

    public function getShouldRender(): bool
    {
        return $this->shouldRender;
    }

    public function render(): ?string
    {
        try {
            $result = $this->when($this->getShouldRender(), fn () => view($this->view, [
                ...$this->extractPublicMethods($this),
            ])->render());

            return is_string($result) ? $result : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
