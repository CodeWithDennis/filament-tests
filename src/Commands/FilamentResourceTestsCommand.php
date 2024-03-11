<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class FilamentResourceTestsCommand extends Command
{
    protected $signature = 'filament:make-test {name?}';

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
        $name = $this->argument('name');
        $singularName = Str::of($name)->singular()->remove('resource', false);
        $pluralName = Str::of($name)->plural()->remove('resource', false);;

        return [
            'resource' => $this->getResourceName(),
            'model' => $this->getModel(),
            'singular_name' => $singularName,
            'singular_name_lowercase' => $singularName->lower(),
            'plural_name' => $pluralName,
            'plural_name_lowercase' => $pluralName->lower(),
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

    protected function getModel(): ?string
    {
        return $this->getResourceClass()->getModel();
    }

    protected function getResourceName(): ?string
    {
        return Str::of($this->argument('name'))->words()->endsWith('Resource') ?
            $this->argument('name') :
            $this->argument('name').'Resource';
    }

    protected function getResourceClass(): ?Resource
    {
        $match = collect(Filament::getResources())
            ->first(fn($resource): bool => str_contains($resource, $this->getResourceName()) && class_exists($resource));

        return $match ? app()->make($match) : null;
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
