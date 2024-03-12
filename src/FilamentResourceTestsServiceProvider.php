<?php

namespace CodeWithDennis\FilamentResourceTests;

use CodeWithDennis\FilamentResourceTests\Commands\FilamentResourceTestsCommand;
use CodeWithDennis\FilamentResourceTests\Commands\PublishStubsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentResourceTestsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-resource-tests')
            ->hasConfigFile()
            ->hasCommands([
                FilamentResourceTestsCommand::class,
                PublishStubsCommand::class,
            ]);
    }
}
