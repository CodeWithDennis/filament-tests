<?php

namespace CodeWithDennis\FilamentResourceTests\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodeWithDennis\FilamentResourceTests\FilamentResourceTests
 */
class FilamentResourceTests extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \CodeWithDennis\FilamentResourceTests\FilamentResourceTests::class;
    }
}
