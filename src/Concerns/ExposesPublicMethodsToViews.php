<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use CodeWithDennis\FilamentTests\TestRenderers\BaseTest;
use ReflectionClass;
use ReflectionMethod;

trait ExposesPublicMethodsToViews
{
    protected array $methodCache = [];

    protected function extractPublicMethods(BaseTest $renderer): array
    {
        if (! isset($this->methodCache[$renderer::class])) {
            $reflection = new ReflectionClass($renderer);

            $this->methodCache[$renderer::class] = array_map(
                fn (ReflectionMethod $method): string => $method->getName(),
                $reflection->getMethods(ReflectionMethod::IS_PUBLIC),
            );
        }

        $values = [];

        foreach ($this->methodCache[$renderer::class] as $method) {
            $values[$method] = $renderer->$method(...);
        }

        return $values;
    }
}
