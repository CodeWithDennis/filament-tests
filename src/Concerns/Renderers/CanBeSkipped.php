<?php

namespace CodeWithDennis\FilamentTests\Concerns\Renderers;

trait CanBeSkipped
{
    public bool $shouldSkip = false;

    public ?string $skipMessage = null;

    public function getShouldSkip(): bool
    {
        return $this->shouldSkip;
    }

    public function getSkipMessage(): ?string
    {
        return $this->skipMessage;
    }
}
