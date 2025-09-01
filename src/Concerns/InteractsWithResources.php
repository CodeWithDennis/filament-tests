<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use CodeWithDennis\FilamentTests\Concerns\Resources\InteractsWithModels;
use CodeWithDennis\FilamentTests\Concerns\Resources\InteractsWithPages;
use CodeWithDennis\FilamentTests\Concerns\Resources\InteractsWithSchemas;
use CodeWithDennis\FilamentTests\Concerns\Resources\InteractsWithTables;
use ReflectionClass;

trait InteractsWithResources
{
    use InteractsWithModels;
    use InteractsWithPages;
    use InteractsWithSchemas;
    use InteractsWithTables;

    protected function getPrivateProperty(object $object, string $property): mixed
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
