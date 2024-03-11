<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class FilamentResourceTestsCommand extends Command
{
    protected $signature = 'filament:test {name?}';

    protected $description = 'Create a new test for a Filament resource.';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    protected function getStubPath(): string
    {
        return __DIR__.'/../../stubs/Resource.stub';
    }

    protected function getStubVariables(): array
    {
        $resource = Str::of($this->argument('name'))->endsWith('Resource') ?
            $this->argument('name') :
            $this->argument('name').'Resource';

        return [
            'resource' => $resource,
            'singular_name' => Str::of($this->argument('name'))->singular(),
            'singular_name_lowercase' => Str::of($this->argument('name'))->singular()->lower(),
            'plural_name' => Str::of($this->argument('name'))->plural(),
            'plural_name_lowercase' => Str::of($this->argument('name'))->plural()->lower(),
        ];
    }

    protected function getSourceFile(): array|bool|string
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    protected function getStubContents($stub, $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    protected function getSourceFilePath(): string
    {
        $name = Str::of($this->argument('name'))->remove('Resource');

        return base_path("tests/Feature/{$name}Test.php");
    }

    protected function makeDirectory($path): string
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    protected function getResource()
    {
        // TODO: Get the filament resource based on the given input ($this->argument('name'))
    }

    protected function getResourceTableColumns()
    {
        // TODO: Get the table columns of the given filament resource
    }

    protected function getResourceSortableTableColumns()
    {
        // TODO: Get the table sortable columns of the given filament resource
    }

    protected function getResourceSearchableTableColumns()
    {
        // TODO: Get the table searchable columns of the given filament resource
    }

    protected function getResourceTableFilters()
    {
        // TODO: Get the table filters of the given filament resource
    }

    public function handle(): void
    {
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if ($this->files->exists($path)) {
            $this->warn("Test for {$this->getStubVariables()['resource']} already exists.");
            return;
        }

        $this->files->put($path, $contents);
        $this->info("Test for {$this->getStubVariables()['resource']} created successfully.");
    }

}
