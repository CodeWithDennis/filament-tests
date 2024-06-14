<?php

namespace CodeWithDennis\FilamentTests;

use CodeWithDennis\FilamentTests\Commands\FilamentTestsCommand;
use CodeWithDennis\FilamentTests\Commands\ListTodosCommand;
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
                ListTodosCommand::class,
            ]);
    }

    public function boot(): void
    {
        parent::boot();

        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs/vendor/filament-tests'),
        ], 'filament-tests-stubs');
    }
}
