<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;

class FilamentResourceTestsCommand extends Command
{
    protected $signature = 'make:filament-resource-test {name? : The name of the resource} {--f|force : Force overwrite the existing test} {--a|all : Create tests for all Filament resources}';

    protected $description = 'Create tests for a Filament components';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    protected function normalizeResourceName(string $name): string
    {
        $name = ucfirst($name);

        if (! str_contains($name, 'Resource')) {
            $name .= 'Resource';
        }

        return $name;
    }

    public function handle(): int
    {
        // Get the available resources
        $availableResources = $this->getResources()
            ->map(fn ($resource): string => str($resource)->afterLast('Resources\\'));

        if (! $this->argument('name')) {
            if (! $this->option('all')) {
                // Ask the user to select the resource they want to create a test for
                $selectedResources = multiselect(
                    label: 'What is the resource you would like to create this test for?',
                    options: $availableResources->flatten(),
                    required: true,
                );

                // Check if the first selected item is numeric (on windows without WSL multiselect returns an array of numeric strings)
                if (is_numeric($selectedResources[0] ?? null)) {
                    // Convert the indexed selection back to the original resource path => resource name
                    $selectedResources = collect($selectedResources)
                        ->mapWithKeys(fn ($index) => [
                            $availableResources->keys()->get($index) => $availableResources->get($availableResources->keys()->get($index)),
                        ]);
                }
            } else {
                // User wants to create tests for all resources
                $selectedResources = $availableResources->all();
            }
        } else {
            // User supplied a resource name
            $suppliedResourceName = $this->normalizeResourceName($this->argument('name'));

            if (! $availableResources->contains($suppliedResourceName)) {
                $this->error("The resource {$suppliedResourceName} does not exist.");

                return self::FAILURE;
            }

            $selectedResources = [$availableResources->search($suppliedResourceName) => $suppliedResourceName];
        }

        foreach ($selectedResources as $selectedResource) {
            // Get the resource class based on the selected resource
            $resource = $this->getResourceClass($selectedResource);

            // Get the path where the test file will be created
            $path = $this->getSourceFilePath($selectedResource);

            // Create the directory if it doesn't exist
            // TODO: (fix) We don't need to create the directory if it already exists (looping right now)
            $this->makeDirectory(dirname($path));

            // Get the contents of the test file
            $contents = $this->getSourceFile($resource);

            if ($this->files->exists($path) && ! $this->option('force')) {
                // Ask the user if they want to overwrite the existing test
                if (! confirm("The test for {$selectedResource} already exists. Do you want to overwrite it?")) {
                    // Skip this resource
                    continue;
                }
            }

            // Write the contents to the file
            $this->files->put($path, $contents);

            // Output a success message
            $this->info("Test for {$selectedResource} created successfully.");
        }

        // Return success
        return self::SUCCESS;
    }

    protected function getTableColumns(Resource $resource): Collection
    {
        return collect($this->getResourceTable($resource)->getColumns());
    }

    protected function getSearchableColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isSearchable());
    }

    protected function getSortableColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isSortable());
    }

    protected function getIndividuallySearchableColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isIndividuallySearchable());
    }

    protected function getToggleableColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isToggleable());
    }

    protected function getToggledHiddenByDefaultColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isToggledHiddenByDefault());
    }

    protected function getInitiallyVisibleColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => ! $column->isToggledHiddenByDefault());
    }

    protected function hasSoftDeletes(Resource $resource): bool
    {
        return method_exists($resource->getModel(), 'bootSoftDeletes');
    }

    protected function getResourceTableActions(Resource $resource): Collection
    {
        return collect($this->getResourceTable($resource)->getFlatActions());
    }

    protected function getResourceTableActionNames(Resource $resource): Collection
    {
        return $this->getResourceTableActions($resource)->map(fn ($action) => $action->getName());
    }

    protected function getResourceTableBulkActions(Resource $resource): Collection
    {
        return collect($this->getResourceTable($resource)->getFlatBulkActions());
    }

    protected function getResourceTableBulkActionNames(Resource $resource): Collection
    {
        return $this->getResourceTableBulkActions($resource)->map(fn ($action) => $action->getName());
    }
}
