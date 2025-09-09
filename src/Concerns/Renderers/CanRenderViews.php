<?php

namespace CodeWithDennis\FilamentTests\Concerns\Renderers;

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
            if (! $this->getShouldRender()) {
                return null;
            }

            $rendered = view($this->view, [
                ...$this->extractPublicMethods($this),
            ])->render();

            if (is_string($rendered)) {

                self::$generatedTestsCounter++;

                return $rendered;
            }

            return null;

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
