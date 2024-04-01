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
            ->name('filament-resource-tests')
            ->hasConfigFile()
            ->hasCommand(FilamentResourceTestsCommand::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../stubs' => base_path('stubs/vendor/filament-resource-tests'),
        ], 'filament-resource-tests-stubs');
    }
}
