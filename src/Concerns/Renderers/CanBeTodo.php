<?php

namespace CodeWithDennis\FilamentTests\Concerns\Renderers;

trait CanBeTodo
{
    public bool $isTodo = false;

    public ?string $todoMessage = null;

    public function todo(): static
    {
        $this->isTodo = true;

        return $this;
    }

    public function isTodo(): bool
    {
        return $this->isTodo;
    }

    public function todoMessage(string $message): static
    {
        $this->todoMessage = $message;

        return $this;
    }

    public function getTodoMessage(): ?string
    {
        return $this->todoMessage;
    }
}
