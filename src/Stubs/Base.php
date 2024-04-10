<?php

namespace CodeWithDennis\FilamentTests\Stubs;

use Closure;
use CodeWithDennis\FilamentTests\Concerns\HasGroup;
use CodeWithDennis\FilamentTests\Concerns\HasName;
use CodeWithDennis\FilamentTests\Concerns\HasPath;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

abstract class Base implements HasGroup, HasName, HasPath
{
    use EvaluatesClosures;

    public Resource $resource;

    public ?string $stubRoot = null;

    public ?string $relativePath = null;

    public ?string $absolutePath = null;

    public array $variables = [];

    public ?string $group = null;

    public string $name = '';

    public Closure|bool|null $shouldGenerate = true;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public static function make(Resource $resource): self
    {
        return new static($resource);
    }

    public function stubRoot(string|Closure|null $stubRoot): static
    {
        $this->stubRoot = $stubRoot;

        return $this;
    }

    public function getStubRoot(): string
    {
        $default = __DIR__.'/../../stubs';

        return $this->evaluate($this->stubRoot ?? $default);
    }

    public function group(string|Closure|null $group): static
    {
        $this->group = $group;

        return $this;
    }

    public function getGroup(): ?string
    {
        return $this->evaluate($this->group);
    }

    public function path(string|Closure|null $path): static
    {
        $this->relativePath = $path;

        return $this;
    }

    public function getRelativePath(): string
    {
        $group = [rtrim($this->getGroup(), DIRECTORY_SEPARATOR)];

        $group = array_filter($group, function ($part) {
            return ! empty($part);
        });

        $relativePath = implode(DIRECTORY_SEPARATOR, $group);

        $parts = [rtrim($relativePath, DIRECTORY_SEPARATOR)];

        $parts = array_filter($parts, function ($part) {
            return ! empty($part);
        });

        $default = implode(DIRECTORY_SEPARATOR, $parts);

        return $this->evaluate($this->relativePath ?? $default);
    }

    public function name(string|Closure|null $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->evaluate($this->name);
    }

    public function absolutePath(string|Closure|null $absolutePath): static
    {
        $this->absolutePath = $absolutePath;

        return $this;
    }

    public function getAbsolutePath(): string
    {
        $absolutePath = $this->getStubRoot().DIRECTORY_SEPARATOR.$this->getRelativePath().DIRECTORY_SEPARATOR.$this->getName().'.stub';
        $parts = explode(DIRECTORY_SEPARATOR, $absolutePath);

        $parts = array_filter($parts, function ($part) {
            return ! empty($part);
        });

        $default = implode(DIRECTORY_SEPARATOR, $parts);

        return $this->evaluate($this->absolutePath ?? $default);
    }

    public function variables(array|Closure|null $variables): static
    {
        $this->variables = $variables;

        return $this;
    }

    public function getVariables(): array
    {
        $defaults = [
            'RESOLVED_GROUP_METHOD' => $this->getGroupMethod($this->group),
        ];

        $variables = $this->variables ?? [];

        return $this->evaluate(array_merge($defaults, $variables));
    }

    public function shouldGenerate(bool|Closure|null $condition): static
    {
        $this->shouldGenerate = $condition;

        return $this;
    }

    public function getShouldGenerate(): bool
    {
        return (bool) ($this->evaluate($this->shouldGenerate) ?? false);
    }

    public function get(): ?array
    {
        if (! $this->getShouldGenerate()) {
            return null;
        }

        return [
            'name' => $this->getName(),
            'group' => $this->getGroup(),
            'fileName' => $this->getName().'.stub',
            'rootPath' => $this->getStubRoot(),
            'relativePath' => $this->getRelativePath(),
            'absolutePath' => $this->getAbsolutePath(),
            'variables' => $this->getVariables(),
            'hasDataset' => false,
        ];
    }

    public function convertDoubleQuotedArrayString(string $string): string
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

    public function getResourceRequiredCreateFields(Resource $resource): Collection
    {
        return collect($this->getResourceCreateForm($resource)->getFlatFields())
            ->filter(fn ($field) => $field->isRequired());
    }

    public function getResourceRequiredEditFields(Resource $resource): Collection
    {
        return collect($this->getResourceEditForm($resource)->getFlatFields())
            ->filter(fn ($field) => $field->isRequired());
    }

    public function getResourceCreateFields(Resource $resource): array
    {
        return $this->getResourceCreateForm($resource)->getFlatFields();
    }

    public function getResourceEditFields(Resource $resource): array
    {
        return $this->getResourceEditForm($resource)->getFlatFields();
    }

    public function getResourceEditForm(Resource $resource): Form
    {
        $livewire = app('livewire')->new(EditRecord::class);

        return $resource::form(new Form($livewire));
    }

    public function getResourceCreateForm(Resource $resource): Form
    {
        $livewire = app('livewire')->new(CreateRecord::class);

        return $resource::form(new Form($livewire));
    }

    public function getResourceTable(Resource $resource): Table
    {
        $livewire = app('livewire')->new(ListRecords::class);

        return $resource::table(new Table($livewire));
    }

    public function getResourcePages(Resource $resource): Collection
    {
        return collect($resource::getPages())->keys();
    }

    public function hasPage(string $name, Resource $resource): bool
    {
        return $this->getResourcePages($resource)->contains($name);
    }

    public function tableHasPagination(Resource $resource): bool
    {
        return $this->getResourceTable($resource)->isPaginated();
    }

    public function tableHasHeading(Resource $resource): bool
    {
        return $this->getResourceTable($resource)->getHeading() !== null;
    }

    public function getTableHeading(Resource $resource): ?string
    {
        return $this->getResourceTable($resource)->getHeading();
    }

    public function tableHasDescription(Resource $resource): bool
    {
        return $this->getResourceTable($resource)->getDescription() !== null;
    }

    public function getTableDescription(Resource $resource): ?string
    {
        return $this->getResourceTable($resource)->getDescription();
    }

    public function getTableDefaultPaginationPageOption(Resource $resource): int|string|null
    {
        return $this->getResourceTable($resource)->getDefaultPaginationPageOption();
    }

    public function getTableColumns(Resource $resource): Collection
    {
        return collect($this->getResourceTable($resource)->getColumns());
    }

    public function getSearchableColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isSearchable());
    }

    public function getSortableColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isSortable());
    }

    public function getIndividuallySearchableColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isIndividuallySearchable());
    }

    public function getToggleableColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isToggleable());
    }

    public function getToggledHiddenByDefaultColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->isToggledHiddenByDefault());
    }

    public function getInitiallyVisibleColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => ! $column->isToggledHiddenByDefault());
    }

    public function getDescriptionAboveColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => method_exists($column, 'description') &&
                $column->getDescriptionAbove()
            );
    }

    public function getDescriptionBelowColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => method_exists($column, 'description') &&
                $column->getDescriptionBelow()
            );
    }

    public function getTableColumnDescriptionAbove(Resource $resource): array
    {
        return $this->getDescriptionAboveColumns($resource)
            ->map(fn ($column) => [
                'column' => $column->getName(),
                'description' => $column->getDescriptionAbove(),
            ])->toArray();
    }

    public function getTableColumnDescriptionBelow(Resource $resource): array
    {
        return $this->getDescriptionBelowColumns($resource)
            ->map(fn ($column) => [
                'column' => $column->getName(),
                'description' => $column->getDescriptionBelow(),
            ])->toArray();
    }

    public function getExtraAttributesColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column->getExtraAttributes());
    }

    public function getExtraAttributesColumnValues(Resource $resource): array
    {
        return $this->getExtraAttributesColumns($resource)
            ->map(fn ($column) => [
                'column' => $column->getName(),
                'attributes' => $column->getExtraAttributes(),
            ])->toArray();
    }

    public function getTableSelectColumns(Resource $resource): Collection
    {
        return $this->getTableColumns($resource)
            ->filter(fn ($column) => $column instanceof \Filament\Tables\Columns\SelectColumn);
    }

    public function getTableSelectColumnsWithOptions(Resource $resource): array
    {
        return $this->getTableSelectColumns($resource)
            ->map(fn ($column) => [
                'column' => $column->getName(),
                'options' => $column->getOptions(),
            ])->toArray();
    }

    public function hasSoftDeletes(Resource $resource): bool
    {
        return method_exists($resource->getModel(), 'bootSoftDeletes');
    }

    public function getResourceTableActions(Resource $resource): Collection
    {
        return collect($this->getResourceTable($resource)->getFlatActions());
    }

    public function getResourceTableBulkActions(Resource $resource): Collection
    {
        return collect($this->getResourceTable($resource)->getFlatBulkActions());
    }

    public function getResourceTableFilters(Table $table): Collection
    {
        return collect($table->getFilters());
    }

    public function tableHasDeferredLoading(Resource $resource): bool
    {
        return $this->getResourceTable($resource)->isLoadingDeferred();
    }

    public function getIndexHeaderActions(Resource $resource): Collection
    {
        $defaults = [
            'all' => collect(),
            'visible' => collect(),
            'hidden' => collect(),
        ];

        $indexPage = $resource::getPages()['index'] ?? null;

        if (! $indexPage) {
            return collect($defaults);
        }

        try {
            $reflection = new \ReflectionClass($indexPage);

            $pageProperty = $reflection->getProperty('page');

            $page = $pageProperty->getValue($indexPage);

            $page = app()->make($page);

            $reflection = new \ReflectionClass($page);

            $getHeaderActionsProperty = $reflection->getMethod('getHeaderActions');

            $actions = $getHeaderActionsProperty->invoke($page);

            return collect([
                'all' => collect($actions)->map(fn ($action) => $action->getName()),

                'visible' => collect($actions)
                    ->filter(fn ($action) => $action->isVisible())
                    ->map(fn ($action) => $action->getName()),

                'hidden' => collect($actions)
                    ->filter(fn ($action) => ! $action->isVisible())
                    ->map(fn ($action) => $action->getName()),
            ]);

        } catch (\Throwable) {
            return collect($defaults);
        }
    }

    public function getTableActionNames(Resource $resource): Collection
    {
        return $this->getResourceTableActions($resource)->map(fn ($action) => $action->getName());
    }

    public function getTableActionsWithUrl(Resource $resource): Collection
    {
        return $this->getResourceTableActions($resource)
            ->filter(fn ($action) => $action->getUrl() && ! $action->shouldOpenUrlInNewTab());
    }

    public function getTableActionsWithUrlThatShouldOpenInNewTab(Resource $resource): Collection
    {
        return $this->getResourceTableActions($resource)
            ->filter(fn ($action) => $action->getUrl() && $action->shouldOpenUrlInNewTab());
    }

    public function hasTableActionWithUrl(Resource $resource): bool
    {
        return $this->getTableActionsWithUrl($resource)->isNotEmpty();
    }

    public function hasTableActionWithUrlThatShouldOpenInNewTab(Resource $resource): bool
    {
        return $this->getTableActionsWithUrlThatShouldOpenInNewTab($resource)->isNotEmpty();
    }

    public function getTableActionsWithUrlNames(Resource $resource): Collection
    {
        return $this->getTableActionsWithUrl($resource)
            ->map(fn ($action) => $action->getName());
    }

    public function getTableActionsWithUrlThatShouldOpenInNewTabNames(Resource $resource): Collection
    {
        return $this->getTableActionsWithUrlThatShouldOpenInNewTab($resource)->map(fn ($action) => $action->getName());
    }

    public function getTableActionsWithUrlValues(Resource $resource): array
    {
        return $this->getTableActionsWithUrl($resource)->map(fn ($action) => [
            'name' => $action->getName(),
            'url' => $action->getUrl(),
        ])->toArray();
    }

    public function getTableActionsWithUrlThatShouldOpenInNewTabValues(Resource $resource): array
    {
        return $this->getTableActionsWithUrlThatShouldOpenInNewTab($resource)->map(fn ($action) => [
            'name' => $action->getName(),
            'url' => $action->getUrl(),
        ])->toArray();
    }

    public function hasTableAction(string $action, Resource $resource): bool
    {
        return $this->getResourceTableActions($resource)->map(fn ($action) => $action->getName())->contains($action);
    }

    public function hasAnyTableAction(Resource $resource, array $actions): bool
    {
        return $this->getResourceTableActions($resource)->map(fn ($action) => $action->getName())->intersect($actions)->isNotEmpty();
    }

    public function hasAnyTableBulkAction(Resource $resource, array $actions): bool
    {
        return $this->getResourceTableBulkActions($resource)->map(fn ($action) => $action->getName())->intersect($actions)->isNotEmpty();
    }

    public function hasAnyIndexHeaderAction(Resource $resource, array $actions): bool
    {
        return $this->getIndexHeaderActions($resource)['all']->intersect($actions)->isNotEmpty();
    }

    public function hasAnyHiddenIndexHeaderAction(Resource $resource, array $actions): bool
    {
        return $this->getIndexHeaderActions($resource)['hidden']->intersect($actions)->isNotEmpty();
    }

    public function hasAnyVisibleIndexHeaderAction(Resource $resource, array $actions): bool
    {
        return $this->getIndexHeaderActions($resource)['visible']->intersect($actions)->isNotEmpty();
    }

    public function hasTableBulkAction(string $action, Resource $resource): bool
    {
        return $this->getResourceTableBulkActions($resource)->map(fn ($action) => $action->getName())->contains($action);
    }

    public function getTableBulkActionNames(Resource $resource): Collection
    {
        return $this->getResourceTableBulkActions($resource)->map(fn ($action) => $action->getName());
    }

    public function hasTableFilter(string $filter, Table $table): bool
    {
        return $this->getResourceTableFilters($table)->map(fn ($filter) => $filter->getName())->contains($filter);
    }

    public function getDeferredLoadingMethod(): string
    {
        return "\n\t\t->loadTable()";
    }

    protected function getGroupMethod(): string
    {
        return "->group({$this->toGroupMethod()})";
    }

    protected function toGroupMethod(): ?string
    {
        $group = $this->getGroup();

        $parts = array_filter(array_map(fn ($part) => "'".strtolower($part)."'", explode('/', $group)));

        return $this->convertDoubleQuotedArrayString(implode(', ', $parts));
    }
}
