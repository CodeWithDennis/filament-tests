<?php

namespace CodeWithDennis\FilamentTests;

use CodeWithDennis\FilamentTests\Commands\FilamentTestsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTestsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-tests')
            ->hasConfigFile()
            ->hasCommand(FilamentTestsCommand::class);
    }
}
