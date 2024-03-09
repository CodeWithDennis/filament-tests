<?php

namespace CodeWithDennis\FilamentResourceTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use CodeWithDennis\FilamentResourceTests\Commands\FilamentResourceTestsCommand;

class FilamentResourceTestsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-resource-tests')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament-resource-tests_table')
            ->hasCommand(FilamentResourceTestsCommand::class);
    }
}
