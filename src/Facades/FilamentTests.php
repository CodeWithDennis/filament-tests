<?php

namespace CodeWithDennis\FilamentResourceTests\Facades;

use Illuminate\Support\Facades\Facade;

class FilamentTests extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \CodeWithDennis\FilamentResourceTests\FilamentTests::class;
    }
}
