<?php

namespace CodeWithDennis\FilamentResourceTests\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use CodeWithDennis\FilamentResourceTests\FilamentResourceTestsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

//        Factory::guessFactoryNamesUsing(
//            fn (string $modelName) => 'CodeWithDennis\\FilamentResourceTests\\Database\\Factories\\'.class_basename($modelName).'Factory'
//        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentResourceTestsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'filament-resource-tests-testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        $migration->up();
        */
    }
}
