<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

use function Laravel\Prompts\select;

class FilamentResourceTestsCommand extends Command
{
    protected $signature = 'make:filament-resource-test {name?}';

    protected $description = 'Create a new test for a Filament resource.';

    protected ?string $resourceName;

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
        $name = $this->resourceName;
        $singularName = str($name)->singular()->remove('resource', false);
        $pluralName = str($name)->plural()->remove('resource', false);

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
        $directory = trim(config('filament-resource-tests.directory_name'), '/');

        if (config('filament-resource-tests.separate_tests_into_folders')) {
            $directory .= DIRECTORY_SEPARATOR . $this->resourceName;
        }

        return $directory . DIRECTORY_SEPARATOR . $this->getResourceName() . 'Test.php';
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
        return $this->getResourceClass()?->getModel();
    }

    protected function getResourceName(): ?string
    {
        return str($this->resourceName)->endsWith('Resource') ?
            $this->resourceName :
            $this->resourceName.'Resource';
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
        // Get the resource name from the command argument
        $this->resourceName = $this->argument('name');

        // Get all available resources
        $availableResources = collect(Filament::getResources())
            ->map(fn($resource): string => str($resource)->afterLast('Resources\\'));

        // Ask the user for the resource
        $this->resourceName = (string) str(
            $this->resourceName ?? select(
            label: 'What is the resource you would like to create this test for?',
            options: $availableResources->flatten(),
            required: true,
        ),
        )
            ->studly()
            ->trim('/')
            ->trim('\\')
            ->trim(' ')
            ->replace('/', '\\');

        // If the resource does not end with 'Resource', append it
        if (!str($this->resourceName)->endsWith('Resource')) {
            $this->resourceName .= 'Resource';
        }

        // Check if the resource exists
        if (!$this->getResourceClass()) {
            $this->warn("The filament resource {$this->resourceName} does not exist.");
            return;
        }

        // Get the source file path
        $path = $this->getSourceFilePath();

        // Make the directory if it does not exist
        $this->makeDirectory(dirname($path));

        // Get the source file contents
        $contents = $this->getSourceFile();

        // Check if the test already exists
        if ($this->files->exists($path)) {
            $this->warn("Test for {$this->getResourceName()} already exists.");
            return;
        }

        // Write the file
        $this->files->put($path, $contents);

        // Output success message
        $this->info("Test for {$this->getResourceName()} created successfully.");
    }

}
