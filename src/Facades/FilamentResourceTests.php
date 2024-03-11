<?php

namespace CodeWithDennis\FilamentResourceTests\Facades;

use Illuminate\Support\Facades\Facade;

class FilamentResourceTests extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \CodeWithDennis\FilamentResourceTests\FilamentResourceTests::class;
    }
}
