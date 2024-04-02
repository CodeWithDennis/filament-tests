<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;

class FilamentResourceTestsCommand extends Command
{
    protected $signature = 'make:filament-resource-test
                            {name? : The name of the resource}
                            {--a|all : Create tests for all Filament resources}
                            {--f|force : Force overwrite the existing test}';

    protected $description = 'Create tests for a Filament components';

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $availableResources = $this->getAvailableResources();

        if (! $this->argument('name')) {
            // Ask the user to select the resource they want to create a test for
            $selectedResources = ! $this->option('all') ? multiselect(
                label: 'What is the resource you would like to create this test for?',
                options: $availableResources->flatten(),
                required: true,
            ) : $availableResources->flatten();

            // Check if the first selected item is numeric (on windows without WSL multiselect returns an array of numeric strings)
            if (is_numeric($selectedResources[0] ?? null)) {
                // Convert the indexed selection back to the original resource path => resource name
                $selectedResources = collect($selectedResources)
                    ->mapWithKeys(fn ($index) => [
                        $availableResources->keys()->get($index) => $availableResources->get($availableResources->keys()->get($index)),
                    ]);
            }
        } else {
            // User supplied a resource name
            $suppliedResourceName = $this->getNormalizedResourceName($this->argument('name'));

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

    protected function getResourcePages(Resource $resource): Collection
    {
        return collect($resource::getPages())->keys();
    }

    protected function hasPage(string $name, Resource $resource): bool
    {
        return $this->getResourcePages($resource)->contains($name);
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

    protected function getResourceTableBulkActions(Resource $resource): Collection
    {
        return collect($this->getResourceTable($resource)->getFlatBulkActions());
    }

    protected function getResourceTableFilters(Table $table): Collection
    {
        return collect($table->getFilters());
    }

    protected function hasTableAction(string $action, Resource $resource): bool
    {
        return $this->getResourceTableActions($resource)->map(fn ($action) => $action->getName())->contains($action);
    }

    protected function hasTableBulkAction(string $action, Resource $resource): bool
    {
        return $this->getResourceTableBulkActions($resource)->map(fn ($action) => $action->getName())->contains($action);
    }

    protected function hasTableFilter(string $filter, Table $table): bool
    {
        return $this->getResourceTableFilters($table)->map(fn ($filter) => $filter->getName())->contains($filter);
    }

    protected function getStubs(Resource $resource): array
    {
        // Get the resource table
        $resourceTable = $this->getResourceTable($resource);

        // Base stubs that are always included
        $stubs = ['Base', 'RenderPage'];

        // Check if there is a create page
        if ($this->hasPage('create', $resource)) {
            $stubs[] = 'Create';
        }

        // Check if there is an edit page
        if ($this->hasPage('edit', $resource)) {
            $stubs[] = 'Edit';
        }

        // Add additional stubs based on the columns
        if ($this->getTableColumns($resource)->isNotEmpty()) {
            $stubs[] = 'HasColumn';
            $stubs[] = 'RenderColumn';
        }

        // Check if there are sortable columns
        if ($this->getSortableColumns($resource)->isNotEmpty()) {
            $stubs[] = 'SortColumn';
        }

        // Check if there are searchable columns
        if ($this->getSearchableColumns($resource)->isNotEmpty()) {
            $stubs[] = 'SearchColumn';
        }

        // Check if there are individually searchable columns
        if ($this->getIndividuallySearchableColumns($resource)->isNotEmpty()) {
            $stubs[] = 'IndividuallySearchColumn';
        }

        // Check that trashed columns are not displayed by default
        if ($this->hasSoftDeletes($resource) && $this->getTableColumns($resource)->isNotEmpty()) {
            $stubs[] = 'Trashed';
        }

        // Check if there is a delete action
        if ($this->hasTableAction('delete', $resource)) {
            $stubs[] = ! $this->hasSoftDeletes($resource) ? 'Delete' : 'SoftDelete';
        }

        // Check if there is a bulk delete action
        if ($this->hasTableBulkAction('delete', $resource)) {
            $stubs[] = ! $this->hasSoftDeletes($resource) ? 'BulkDelete' : 'BulkSoftDelete';
        }

        // Check if there is a replicate action
        if ($this->hasTableAction('replicate', $resource)) {
            $stubs[] = 'Replicate';
        }

        // Check if there is a trashed filter
        if ($this->hasTableFilter('trashed', $resourceTable) && $this->hasSoftDeletes($resource)) {
            // Check if there is a restore action
            if ($this->hasTableAction('restore', $resource)) {
                $stubs[] = 'Restore';
            }

            // Check if there is a bulk restore action
            if ($this->hasTableBulkAction('restore', $resource)) {
                $stubs[] = 'BulkRestore';
            }

            // Check if there is a force delete action
            if ($this->hasTableAction('forceDelete', $resource)) {
                $stubs[] = 'ForceDelete';
            }

            // Check if there is a bulk force delete action
            if ($this->hasTableBulkAction('forceDelete', $resource)) {
                $stubs[] = 'BulkForceDelete';
            }
        }

        // Return the stubs
        return $stubs;
    }

    protected function getResources(): Collection
    {
        return collect(Filament::getResources());
    }

    protected function getResourceClass(string $resource): ?Resource
    {
        $match = $this->getResources()
            ->first(fn ($value): bool => str_contains($value, $resource) && class_exists($value));

        return $match ? app()->make($match) : null;
    }

    // Get the available resources
    protected function getAvailableResources(): Collection
    {
        return $this->getResources()->map(fn ($resource): string => str($resource)->afterLast('Resources\\'));
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

    protected function getSourceFile(Resource $resource): array|bool|string
    {
        $contents = '';

        foreach ($this->getStubs($resource) as $stub) {
            $contents .= $this->getStubContents(__DIR__.'/../../stubs/'.$stub.'.stub', $this->getStubVariables($resource));
        }

        return $contents;
    }

    protected function getStubContents(string $stub, array $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents.PHP_EOL;
    }

    protected function getResourceRequiredCreateFields(Resource $resource): Collection
    {
        return collect($this->getResourceCreateForm($resource)->getFlatFields())
            ->filter(fn ($field) => $field->isRequired());
    }

    protected function getResourceRequiredEditFields(Resource $resource): Collection
    {
        return collect($this->getResourceEditForm($resource)->getFlatFields())
            ->filter(fn ($field) => $field->isRequired());
    }

    protected function getResourceCreateFields(Resource $resource): array
    {
        return $this->getResourceCreateForm($resource)->getFlatFields();
    }

    protected function getResourceEditFields(Resource $resource): array
    {
        return $this->getResourceEditForm($resource)->getFlatFields();
    }

    protected function getResourceEditForm(Resource $resource): Form
    {
        $livewire = app('livewire')->new(EditRecord::class);

        return $resource::form(new Form($livewire));
    }

    protected function getResourceCreateForm(Resource $resource): Form
    {
        $livewire = app('livewire')->new(CreateRecord::class);

        return $resource::form(new Form($livewire));
    }

    protected function getResourceTable(Resource $resource): Table
    {
        $livewire = app('livewire')->new(ListRecords::class);

        return $resource::table(new Table($livewire));
    }

    protected function convertDoubleQuotedArrayString(string $string): string
    {
        return str($string)
            ->replace('"', '\'')
            ->replace(',', ', ');
    }

    protected function getStubVariables(Resource $resource): array
    {
        $resourceModel = $resource->getModel();
        $userModel = User::class;
        $modelImport = $resourceModel === $userModel ? "use {$resourceModel};" : "use {$resourceModel};\nuse {$userModel};";

        $toBeConverted = [
            'RESOURCE_TABLE_COLUMNS' => $this->getTableColumns($resource)->keys(),
            'RESOURCE_TABLE_COLUMNS_INITIALLY_VISIBLE' => $this->getInitiallyVisibleColumns($resource)->keys(),
            'RESOURCE_TABLE_COLUMNS_TOGGLED_HIDDEN_BY_DEFAULT' => $this->getToggledHiddenByDefaultColumns($resource)->keys(),
            'RESOURCE_TABLE_TOGGLEABLE_COLUMNS' => $this->getToggleableColumns($resource)->keys(),
            'RESOURCE_TABLE_SORTABLE_COLUMNS' => $this->getSortableColumns($resource)->keys(),
            'RESOURCE_TABLE_SEARCHABLE_COLUMNS' => $this->getSearchableColumns($resource)->keys(),
            'RESOURCE_TABLE_INDIVIDUALLY_SEARCHABLE_COLUMNS' => $this->getIndividuallySearchableColumns($resource)->keys(),
        ];

        $converted = array_map(function ($value) {
            return $this->convertDoubleQuotedArrayString($value);
        }, $toBeConverted);

        return array_merge([
            'RESOURCE' => str($resource::class)->afterLast('\\'),
            'MODEL_IMPORT' => $modelImport,
            'MODEL_SINGULAR_NAME' => str($resourceModel)->afterLast('\\'),
            'MODEL_PLURAL_NAME' => str($resourceModel)->afterLast('\\')->plural(),
        ], $converted);
    }

    protected function getNormalizedResourceName(string $name): string
    {
        return str($name)->ucfirst()->finish('Resource');
    }
}
