<?php

namespace CodeWithDennis\FilamentTests\Exceptions;

use Exception;

class GlobalConfiguredUsingCouldNotBeDeterminedException extends Exception
{
    public function __construct(string $class, string $method)
    {
        parent::__construct("Could not determine the globally configured using for {$class}::{$method}().");
    }
}
