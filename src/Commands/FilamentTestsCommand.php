<?php

namespace CodeWithDennis\FilamentTests\Commands;

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

class FilamentTestsCommand extends Command
{
    protected $signature = 'make:filament-test
                            {name? : The name of the resource}
                            {--a|all : Create tests for all Filament resources}
                            {--f|force : Force overwrite the existing test}';

    protected $description = 'Create a new test for a Filament component';

    protected int $baseUsers = 1;

    protected int $defaultFactoryCount = 3;

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
            $this->files->ensureDirectoryExists(dirname($path));

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

    protected function tableHasPagination(Resource $resource): bool
    {
        return $this->getResourceTable($resource)->isPaginated();
    }

    protected function getTableDefaultPaginationPageOption(Resource $resource): int|string|null
    {
        return $this->getResourceTable($resource)->getDefaultPaginationPageOption();
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

    protected function getDescriptionAboveColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => method_exists($column, 'description') &&
                $column->getDescriptionAbove()
            );
    }

    protected function getDescriptionBelowColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => method_exists($column, 'description') &&
                $column->getDescriptionBelow()
            );
    }

    protected function getTableColumnDescriptionAbove(Resource $resource): array
    {
        return $this->getDescriptionAboveColumns($resource)
            ->map(fn ($column) => [
                'column' => $column->getName(),
                'description' => $column->getDescriptionAbove(),
            ])->toArray();
    }

    protected function getTableColumnDescriptionBelow(Resource $resource): array
    {
        return $this->getDescriptionBelowColumns($resource)
            ->map(fn ($column) => [
                'column' => $column->getName(),
                'description' => $column->getDescriptionBelow(),
            ])->toArray();
    }

    protected function getExtraAttributesColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->getExtraAttributes());
    }

    protected function getExtraAttributesColumnValues(Resource $resource): array
    {
        return $this->getExtraAttributesColumns($resource)
            ->map(fn ($column) => [
                'column' => $column->getName(),
                'attributes' => $column->getExtraAttributes(),
            ])->toArray();
    }

    protected function getTableSelectColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column instanceof \Filament\Tables\Columns\SelectColumn);
    }

    protected function getTableSelectColumnsWithOptions(Resource $resource): array
    {
        return $this->getTableSelectColumns($resource)
            ->map(fn ($column) => [
                'column' => $column->getName(),
                'options' => $column->getOptions(),
            ])->toArray();
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

    protected function tableHasDeferredLoading(Resource $resource): bool
    {
        return $this->getResourceTable($resource)->isLoadingDeferred();
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

    protected function getStubPath(string $for, ?string $in = null): string
    {
        $basePath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'stubs';

        return $in
            ? $basePath.DIRECTORY_SEPARATOR.$in.DIRECTORY_SEPARATOR.$for.'.stub'
            : $basePath.DIRECTORY_SEPARATOR.$for.'.stub';
    }

    protected function getStubs(Resource $resource): array
    {
        // Get the resource table
        $resourceTable = $this->getResourceTable($resource);

        $stubs = [];

        // Base stubs that are always included
        $stubs[] = $this->hasMultiTenancy($resource)
            ? $this->getStubPath('BaseMultiTenancy')
            : $this->getStubPath('Base');

        // Check if there is an index page
        if ($this->hasPage('index', $resource)) {
            $stubs[] = $this->getStubPath('Render', 'Page/Index');
            $stubs[] = $this->getStubPath('ListRecords', 'Page/Index');

            if ($this->tableHasPagination($resource)) {
                $stubs[] = $this->getStubPath('ListRecordsPaginated', 'Page/Index');
            }
        }

        // Check if there is a create page
        if ($this->hasPage('create', $resource)) {
            $stubs[] = $this->getStubPath('Render', 'Page/Create');
        }

        // Check if there is an edit page
        if ($this->hasPage('edit', $resource)) {
            $stubs[] = $this->getStubPath('Render', 'Page/Edit');
        }

        // Check if there is a view page
        if ($this->hasPage('view', $resource)) {
            $stubs[] = $this->getStubPath('Render', 'Page/View');
        }

        // Add additional stubs based on the columns
        if ($this->getTableColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('Exist', 'Page/Index/Table/Columns');
        }

        // Check if there are initially visible columns
        if ($this->getInitiallyVisibleColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('Render', 'Page/Index/Table/Columns');
        }

        // Check if there are toggleable columns that are hidden by default
        if ($this->getToggledHiddenByDefaultColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('CannotRender', 'Page/Index/Table/Columns');
        }

        // Check if there are sortable columns
        if ($this->getSortableColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('Sort', 'Page/Index/Table/Columns');
        }

        // Check if there are searchable columns
        if ($this->getSearchableColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('Search', 'Page/Index/Table/Columns');
        }

        // Check if there are individually searchable columns
        if ($this->getIndividuallySearchableColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('SearchIndividually', 'Page/Index/Table/Columns');
        }

        // Check if there is a description above
        if ($this->getDescriptionAboveColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('DescriptionAbove', 'Page/Index/Table/Columns');
        }

        // Check if there is a description below
        if ($this->getDescriptionBelowColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('DescriptionBelow', 'Page/Index/Table/Columns');
        }

        // Check if there are select columns
        if ($this->getTableSelectColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('Select', 'Page/Index/Table/Columns');
        }

        // Check that trashed columns are not displayed by default
        if ($this->hasSoftDeletes($resource) && $this->getTableColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('Trashed', 'Page/Index');
        }

        // Check if there are columns with extra attributes
        if ($this->getExtraAttributesColumns($resource)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('ExtraAttributes', 'Page/Index/Table/Columns');
        }

        // Check if there is a delete action
        if ($this->hasTableAction('delete', $resource)) {
            $stubs[] = ! $this->hasSoftDeletes($resource)
                ? $this->getStubPath('Delete', 'Page/Index/Table/Actions')
                : $this->getStubPath('SoftDelete', 'Page/Index/Table/Actions');
        }

        // Check if there is a bulk delete action
        if ($this->hasTableBulkAction('delete', $resource)) {
            $stubs[] = ! $this->hasSoftDeletes($resource)
                ? $this->getStubPath('Delete', 'Page/Index/Table/BulkActions')
                : $this->getStubPath('SoftDelete', 'Page/Index/Table/BulkActions');
        }

        // Check if there is a replicate action
        if ($this->hasTableAction('replicate', $resource)) {
            $stubs[] = $this->getStubPath('Replicate', 'Page/Index/Table/Actions');
        }

        // Check there are table filters
        if ($this->getResourceTableFilters($resourceTable)->isNotEmpty()) {
            $stubs[] = $this->getStubPath('Reset', 'Page/Index/Table/Filters');
        }

        // Check if there is a trashed filter
        if ($this->hasTableFilter('trashed', $resourceTable) && $this->hasSoftDeletes($resource)) {
            // Check if there is a restore action
            if ($this->hasTableAction('restore', $resource)) {
                $stubs[] = $this->getStubPath('Restore', 'Page/Index/Table/Actions');
            }

            // Check if there is a force delete action
            if ($this->hasTableAction('forceDelete', $resource)) {
                $stubs[] = $this->getStubPath('ForceDelete', 'Page/Index/Table/Actions');
            }

            // Check if there is a bulk restore action
            if ($this->hasTableBulkAction('restore', $resource)) {
                $stubs[] = $this->getStubPath('Restore', 'Page/Index/Table/BulkActions');
            }

            // Check if there is a bulk force delete action
            if ($this->hasTableBulkAction('forceDelete', $resource)) {
                $stubs[] = $this->getStubPath('ForceDelete', 'Page/Index/Table/BulkActions');
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
        $directory = trim(config('filament-tests.directory_name'), '/');

        if (config('filament-tests.separate_tests_into_folders')) {
            $directory .= DIRECTORY_SEPARATOR.$name;
        }

        return $directory.DIRECTORY_SEPARATOR.$name.'Test.php';
    }

    protected function getSourceFile(Resource $resource): array|bool|string
    {
        $contents = '';

        foreach ($this->getStubs($resource) as $stub) {
            $contents .= $this->getStubContents($stub, $this->getStubVariables($resource));
        }

        return $contents;
    }

    protected function getStubContents(string $stub, array $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = preg_replace("/\{\{\s*{$search}\s*\}\}/", $replace, $contents);
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

    protected function hasMultiTenancy(Resource $resource): bool
    {
        return Filament::getDefaultPanel()->hasTenancy();
    }

    protected function getMultiTenancyModel(): ?string
    {
        return Filament::getDefaultPanel()->getTenantModel();
    }

    protected function getMultiTenancyModelFactoryAttributes(Resource $resource): ?string
    {
        if (! $this->hasMultiTenancy($resource)) {
            return null;
        }

        $tenant = str($this->getMultiTenancyModel())->afterLast('\\')->lower();

        return "['{$tenant}_id' => \$this->{$tenant}->getKey()]";
    }

    protected function convertDoubleQuotedArrayString(string $string): string
    {
        return str($string)
            ->replace('"', '\'')
            ->replace(',', ', ');
    }

    protected function transformToPestDataset(array $source, array $keys): string
    {
        $result = [];

        foreach ($source as $item) {
            $temp = [];

            foreach ($keys as $key) {
                if (isset($item[$key])) {
                    if (is_array($item[$key])) {
                        $nestedArray = [];
                        foreach ($item[$key] as $nestedKey => $nestedValue) {
                            $nestedArray[] = "'$nestedKey' => '$nestedValue'";
                        }
                        $temp[] = '['.implode(', ', $nestedArray).']';
                    } else {
                        $temp[] = "'".$item[$key]."'";
                    }
                }
            }

            $result[] = '['.implode(', ', $temp).']';
        }

        return $this->convertDoubleQuotedArrayString('['.implode(', ', $result).']');
    }

    protected function getStubVariables(Resource $resource): array
    {
        $resourceModel = $resource->getModel();
        $userModel = User::class;
        $modelImport = $resourceModel === $userModel ? "use {$resourceModel};" : "use {$resourceModel};\nuse {$userModel};";


        $toBeConverted = [
            'RESOURCE_TABLE_COLUMNS' => $this->getTableColumns($resource)->keys(),
            'RESOURCE_TABLE_INITIALLY_VISIBLE_COLUMNS' => $this->getInitiallyVisibleColumns($resource)->keys(),
            'RESOURCE_TABLE_TOGGLED_HIDDEN_BY_DEFAULT_COLUMNS' => $this->getToggledHiddenByDefaultColumns($resource)->keys(),
            'RESOURCE_TABLE_INDIVIDUALLY_SEARCHABLE_COLUMNS' => $this->getIndividuallySearchableColumns($resource)->keys(),
            'RESOURCE_TABLE_SEARCHABLE_COLUMNS' => $this->getSearchableColumns($resource)->keys(),
            'RESOURCE_TABLE_SORTABLE_COLUMNS' => $this->getSortableColumns($resource)->keys(),
            'RESOURCE_TABLE_TOGGLEABLE_COLUMNS' => $this->getToggleableColumns($resource)->keys(),
            'DEFAULT_PER_PAGE_OPTION' => $this->getTableDefaultPaginationPageOption($resource),
            'DEFAULT_PAGINATED_RECORDS_FACTORY_COUNT' => $this->getTableDefaultPaginationPageOption($resource) * 2,
            'TENANT_MODEL' => $this->getMultiTenancyModel(),
            'TENANT_MODEL_SINGULAR_NAME' => str($this->getMultiTenancyModel())->afterLast('\\'),
            'TENANT_MODEL_PLURAL_NAME' => str($this->getMultiTenancyModel())->afterLast('\\')->plural(),
            'TENANT_MODEL_SINGULAR_NAME_LOWER' => str($this->getMultiTenancyModel())->afterLast('\\')->lower(),
            'TENANT_MODEL_PLURAL_NAME_LOWER' => str($this->getMultiTenancyModel())->afterLast('\\')->plural()->lower(),
            'USER_MODEL' => $userModel,
            'USER_MODEL_SINGULAR_NAME' => str($userModel)->afterLast('\\'),
            'USER_MODEL_PLURAL_NAME' => str($userModel)->afterLast('\\')->plural,
            'USER_MODEL_SINGULAR_NAME_LOWER' => str($userModel)->afterLast('\\')->lower(),
            'USER_MODEL_PLURAL_NAME_LOWER' => str($userModel)->afterLast('\\')->plural()->lower(),
//            'TENANCY_FACTORY_ATTRIBUTES' => $this->getFactoryAttributes($resource),
        ];

        $converted = array_map(function ($value) {
            return $this->convertDoubleQuotedArrayString($value);
        }, $toBeConverted);

        return array_merge([
            'MODEL_IMPORT' => $modelImport,
            'MODEL_PLURAL_NAME' => str($resourceModel)->afterLast('\\')->plural(),
            'MODEL_SINGULAR_NAME' => str($resourceModel)->afterLast('\\'),
            'RESOURCE' => str($resource::class)->afterLast('\\'),
            'RESOURCE_TABLE_DESCRIPTIONS_ABOVE_COLUMNS' => $this->transformToPestDataset($this->getTableColumnDescriptionAbove($resource), ['column', 'description']),
            'RESOURCE_TABLE_DESCRIPTIONS_BELOW_COLUMNS' => $this->transformToPestDataset($this->getTableColumnDescriptionBelow($resource), ['column', 'description']),
            'RESOURCE_TABLE_EXTRA_ATTRIBUTES_COLUMNS' => $this->transformToPestDataset($this->getExtraAttributesColumnValues($resource), ['column', 'attributes']),
            'RESOURCE_TABLE_SELECT_COLUMNS' => $this->transformToPestDataset($this->getTableSelectColumnsWithOptions($resource), ['column', 'options']),
            'LOAD_TABLE_METHOD_IF_DEFERRED' => $this->tableHasDeferredLoading($resource) ? $this->getDeferredLoadingMethod() : '',
            'MULTI_TENANCY_FACTORY_ATTRIBUTES' => $this->getMultiTenancyModelFactoryAttributes($resource),
        ], $converted);
    }

    protected function getNormalizedResourceName(string $name): string
    {
        return str($name)->ucfirst()->finish('Resource');
    }

    protected function getDeferredLoadingMethod(): string
    {
        return "\n\t\t->loadTable()";
    }
}
