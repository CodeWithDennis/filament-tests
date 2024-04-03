<?php

namespace CodeWithDennis\FilamentResourceTests;

use CodeWithDennis\FilamentResourceTests\Commands\FilamentResourceTestsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentResourceTestsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-tests')
            ->hasConfigFile()
            ->hasCommand(FilamentResourceTestsCommand::class);
    }
}
