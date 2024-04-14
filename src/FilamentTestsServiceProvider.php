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

    public function boot(): void
    {
        parent::boot();

        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs/vendor/filament-tests'),
        ], 'filament-tests-stubs');
    }
}
