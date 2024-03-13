<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

use function Laravel\Prompts\multiselect;

class FilamentResourceTestsCommand extends Command
{
    protected $signature = 'make:filament-resource-test';

    protected $description = 'Create tests for a Filament components';

    protected Filesystem $files;

    protected string $tests = '';

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    protected function getStubPath(): string
    {
        return __DIR__.'/../../stubs/Resource.stub';
    }

    protected function getStubVariables(string $resource, ?string $contents): array
    {
        return [
            'tests' => $contents,
            'resource' => $resource,
            'model' => $this->getResourceModel($resource),
            'model_plural_name' => str($resource)->remove('resource', false)->plural(),
        ];
    }

    protected function getSourceFile(string $resource, $contents): array|bool|string
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables($resource, $contents));
    }

    protected function getStubContents(string $stub, array $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    protected function getSourceFilePath(string $name): string
    {
        $directory = trim(config('filament-resource-tests.directory_name'), '/');

        if (config('filament-resource-tests.separate_tests_into_folders')) {
            $directory .= DIRECTORY_SEPARATOR.$name;
        }

        return $directory.DIRECTORY_SEPARATOR.$name.'Test.php';
    }

    protected function makeDirectory($path): string
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    protected function getResourceModel(string $resource): ?string
    {
        return $this->getResourceClass($resource)?->getModel();
    }

    protected function getResourceClass(string $resource): ?Resource
    {
        $match = $this->getResources()
            ->first(fn ($value): bool => str_contains($value, $resource) && class_exists($value));

        return $match ? app()->make($match) : null;
    }

    protected function getResources(): Collection
    {
        return collect(Filament::getResources());
    }

    protected function getResourceTable(string $resource): Table
    {
        $livewire = app('livewire')->new(ListRecords::class);

        return $this->getResourceClass($resource)::table(new Table($livewire));
    }

    protected function getResourceTableColumns(Table $table): array
    {
        return $table->getColumns();
    }

    protected function getResourceSortableTableColumns(array $columns): Collection
    {
        return collect($columns)->filter(fn ($column) => $column->isSortable());
    }

    protected function getResourceSearchableTableColumns(array $columns): Collection
    {
        return collect($columns)->filter(fn ($column) => $column->isSearchable());
    }

    protected function getResourceTableFilters(Table $table): array
    {
        return $table->getFilters();
    }

    protected function generateTableColumnsExistTests(Stringable $resource): string
    {
        $table = $this->getResourceTable($resource);
        $modelName = str($resource)->remove('resource', false);
        $resourceTests = '';

        $columns = $this->getResourceTableColumns($table);

        foreach (collect($columns)->keys() as $key) {
            $label = str_replace(['.', '_'], ' ', $key);

            $resourceTests .= <<<EOT
            it('can render {$modelName->singular()->lower()} {$label} column', function () {
                {$modelName->singular()}::factory()->count(3)->create();
                livewire(List{$modelName->plural()}::class)->assertCanRenderTableColumn('{$key}');
            });


            EOT;
        }

        return $resourceTests;
    }

    public function handle(): void
    {
        $availableResources = $this->getResources()
            ->map(fn ($resource): string => str($resource)->afterLast('Resources\\'));

        $selectedResources = multiselect(
            label: 'What is the resource you would like to create this test for?',
            options: $availableResources->flatten(),
            required: true,
        );

        foreach ($selectedResources as $selectedResource) {
            $allCurrentlyResourceTests = '';

            $resource = str($selectedResource);

            $allCurrentlyResourceTests .= $this->generateTableColumnsExistTests($resource);

            // Get the source file path
            $path = $this->getSourceFilePath($resource);

            // Make the directory if it does not exist
            $this->makeDirectory(dirname($path));

            // Get the source file contents
            $contents = $this->getSourceFile($resource, $allCurrentlyResourceTests);

            // Check if the test already exists
            if ($this->files->exists($path)) {
                $this->warn("Test for {$resource} already exists.");

                return;
            }

            // Write the file
            $this->files->put($path, $contents);

            // Output success message
            $this->info("Test for {$resource} created successfully.");
        }
    }
}
