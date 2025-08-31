<?php

namespace CodeWithDennis\FilamentTests\Concerns\Renderers;

trait CanBeSkipped
{
    public bool $shouldSkip = false;

    public ?string $skipMessage = null;

    public function skip(): static
    {
        $this->shouldSkip = true;

        return $this;
    }

    public function getShouldSkip(): bool
    {
        return $this->shouldSkip;
    }

    public function skipMessage(string $message): static
    {
        $this->skipMessage = $message;

        return $this;
    }

    public function getSkipMessage(): ?string
    {
        return $this->skipMessage;
    }
}
