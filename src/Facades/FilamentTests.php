<?php

namespace CodeWithDennis\FilamentTests\Facades;

use Illuminate\Support\Facades\Facade;

class FilamentTests extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \CodeWithDennis\FilamentTests\FilamentTests::class;
    }
}
