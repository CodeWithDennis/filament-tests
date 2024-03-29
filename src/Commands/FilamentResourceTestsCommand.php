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
    protected $signature = 'make:filament-resource-test';

    protected $description = 'Create tests for a Filament components';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle(): int
    {
        // Get the available resources
        $availableResources = $this->getResources()
            ->map(fn ($resource): string => str($resource)->afterLast('Resources\\'));

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

            // If the file already exists, ask the user if they want to overwrite it.
            if ($this->files->exists($path)) {
                if (! confirm("Test for {$selectedResource} already exists. Do you want to overwrite it?")) {
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
        return method_exists($resource->getModel(), 'trashed');
    }

    protected function getStubs(Resource $resource): array
    {
        // Base stubs that are always included
        $stubs = ['Base', 'RenderPage'];

        // Get the columns of the resource table
        $columns = collect($this->getResourceTable($resource)->getColumns());

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

    protected function getResourceTableFilters(Table $table): array
    {
        return $table->getFilters();
    }

    protected function getStubVariables(Resource $resource): array // TODO: This part is a bit messy, maybe refactor it
    {
        $resourceModel = $resource->getModel();
        $userModel = User::class;
        $modelImport = $resourceModel === $userModel ? "use {$resourceModel};" : "use {$resourceModel};\nuse {$userModel};";

        return [
            'RESOURCE' => str($resource::class)->afterLast('\\'),
            'MODEL_IMPORT' => $modelImport,
            'MODEL_SINGULAR_NAME' => str($resourceModel)->afterLast('\\'),
            'MODEL_PLURAL_NAME' => str($resourceModel)->afterLast('\\')->plural(),
            'RESOURCE_TABLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getTableColumns($resource)->keys()),
            'RESOURCE_TABLE_COLUMNS_INITIALLY_VISIBLE' => $this->convertDoubleQuotedArrayString($this->getInitiallyVisibleColumns($resource)->keys()),
            'RESOURCE_TABLE_COLUMNS_TOGGLED_HIDDEN_BY_DEFAULT' => $this->convertDoubleQuotedArrayString($this->getToggledHiddenByDefaultColumns($resource)->keys()),
            'RESOURCE_TABLE_TOGGLEABLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getToggleableColumns($resource)->keys()),
            'RESOURCE_TABLE_SORTABLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getSortableColumns($resource)->keys()),
            'RESOURCE_TABLE_SEARCHABLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getSearchableColumns($resource)->keys()),
            'RESOURCE_TABLE_INDIVIDUALLY_SEARCHABLE_COLUMNS' => $this->convertDoubleQuotedArrayString($this->getIndividuallySearchableColumns($resource)->keys()),
        ];
    }
}
