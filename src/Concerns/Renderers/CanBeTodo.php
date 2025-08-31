<?php

namespace CodeWithDennis\FilamentTests\Concerns\Renderers;

trait CanBeTodo
{
    public bool $isTodo = false;

    public ?string $todoMessage = null;

    public function isTodo(): bool
    {
        return $this->isTodo;
    }

    public function getTodoMessage(): ?string
    {
        return $this->todoMessage;
    }
}
