<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use Filament\Facades\Filament;
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

    protected $description = 'Create tests for your Filament resources.';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function renderViewByName($name, $data = []): ?string
    {
        return view('filament-resource-tests::'.$name, $data)->render();
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

    protected function getOutputFilePath(string $name): string
    {
        $directory = trim(config('filament-resource-tests.directory_name'), '/');

        if (config('filament-resource-tests.separate_tests_into_folders')) {
            $directory .= DIRECTORY_SEPARATOR.$name;
        }

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        return $directory.DIRECTORY_SEPARATOR.$name.'Test.php';
    }

    protected function getResourceTable(Resource $resource): Table
    {
        $livewire = app('livewire')->new(ListRecords::class);

        return $resource::table(new Table($livewire));
    }

    public static function getVisibleColumns(Table $table): array
    {
        return collect($table->getColumns())
            ->filter(fn ($column) => ! $column->isToggledHiddenByDefault())
            ->keys()
            ->toArray();
    }

    public static function getSearchableColumns(Table $table): array
    {
        return collect($table->getColumns())
            ->filter(fn ($column) => $column->isSearchable() && ! $column->isToggledHiddenByDefault())
            ->keys()
            ->toArray();
    }

    public static function getIndividuallySearchableColumns(Table $table): array
    {
        return collect($table->getColumns())
            ->filter(fn ($column) => $column->isIndividuallySearchable() && ! $column->isToggledHiddenByDefault())
            ->keys()
            ->toArray();
    }

    public static function getToggleableColumns(Table $table): array
    {
        return collect($table->getColumns())
            ->filter(fn ($column) => $column->isToggleable() && ! $column->isToggledHiddenByDefault())
            ->keys()
            ->toArray();
    }

    public static function getSortableColumns(Table $table): array
    {
        return collect($table->getColumns())
            ->filter(fn ($column) => $column->isSortable() && ! $column->isToggledHiddenByDefault())
            ->keys()
            ->toArray();
    }

    protected function getViewMap(): array
    {
        return [
            'table' => 'table-test',
            //            'form' => 'form-test',
            //            'page' => 'page-test',
        ];
    }

    protected function modelUsesTrait($model, $trait): bool
    {
        return collect(class_uses($model))->contains($trait);
    }

    protected function hasSoftDeletes($model): bool
    {
        return $this->modelUsesTrait($model, 'Illuminate\Database\Eloquent\SoftDeletes')
            && method_exists($model, 'bootSoftDeletes');
    }

    protected function getSingularModelName($model): string
    {
        return str($model)->afterLast('\\');
    }

    protected function getPluralModelName($model): string
    {
        return str($model)->afterLast('\\')->plural();
    }

    public function handle(): int
    {
        $availableResources = $this->getResources()
            ->map(fn ($resource): string => str($resource)->afterLast('Resources\\'));

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
            $resource_class = $this->getResourceClass($selectedResource);

            if (! $resource_class) {
                $this->error("The resource `$selectedResource` does not exist.");

                continue;
            }

            foreach ($this->getViewMap() as $type => $view) {
                $content = $this->renderViewByName($view, [
                    'table' => $this->getResourceTable($resource_class),
                    'resource' => $selectedResource,
                    'resource_model' => $resource_class::getModel(),
                    'resource_model_singular' => $this->getSingularModelName($resource_class::getModel()),
                    'resource_model_plural' => $this->getPluralModelName($resource_class::getModel()),
                    'resource_model_uses_soft_deletes' => $this->hasSoftDeletes($resource_class::getModel()),
                ]);

                if (! empty($content)) {
                    $path = $this->getOutputFilePath($selectedResource);

                    if ($this->files->exists($path)
                        && ! confirm("Test for {$selectedResource} already exists. Do you want to overwrite it?")) {
                        continue;
                    }

                    $this->writeViewToFile($content, $path);

                    $this->info("Test for {$selectedResource} created successfully.");
                }
            }

        }

        return self::SUCCESS;
    }

    public function writeViewToFile(string $renderedView, string $path)
    {
        $this->files->put($path, $renderedView);
    }
}
