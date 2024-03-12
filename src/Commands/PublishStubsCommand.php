<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishStubsCommand extends Command
{
    protected $signature = 'filament-resource-tests:publish-stubs';

    protected $description = 'Publish the Filament Resource Test stubs.';

    public function handle(Filesystem $filesystem)
    {
        $stubsPath = __DIR__.'/../../stubs';
        $targetPath = base_path('stubs/vendor/filament-resource-tests');

        if (! $filesystem->isDirectory($targetPath)) {
            $filesystem->makeDirectory($targetPath, 0755, true);
        }

        foreach ($filesystem->allFiles($stubsPath) as $stub) {
            $targetFilePath = $targetPath.'/'.$stub->getFilename();
            if (! $filesystem->exists($targetFilePath)) {
                $filesystem->copy($stub->getPathname(), $targetFilePath);
            }
        }

        $this->info('Stubs have been published.');
    }
}
