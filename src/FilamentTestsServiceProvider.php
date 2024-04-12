<?php

namespace CodeWithDennis\FilamentTests;

use CodeWithDennis\FilamentTests\Commands\FilamentTestsCommand;
use CodeWithDennis\FilamentTests\Commands\FilamentTestsCreateStubCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTestsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-tests')
            ->hasConfigFile()
            ->hasCommands([
                FilamentTestsCommand::class,
                FilamentTestsCreateStubCommand::class,
            ]);
    }
}
