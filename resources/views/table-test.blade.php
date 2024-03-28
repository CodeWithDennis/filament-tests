@php use CodeWithDennis\FilamentResourceTests\Commands\FilamentResourceTestsCommand; @endphp
@props([
    'table' => $table,
    'description' => null,
    'dataset' => [],
    'dataset_key' => 'column',
    'resource' => $resource,
    'resource_model' => $resource_model,
    'resource_model_singular' => $resource_model_singular,
    'resource_model_plural' => $resource_model_plural,
    'resource_model_uses_soft_deletes' => $resource_model_uses_soft_deletes,
])
<x-filament-resource-tests::test-skeleton
    description="can render page"
    :allow_empty_dataset="true"
>
    livewire(App\Filament\Resources\{{$resource}}\Pages\List{{$resource_model_plural}}::class)->assertOk();
</x-filament-resource-tests::test-skeleton>

<x-filament-resource-tests::test-skeleton
    description="can render columns"
    :skip_reason="$resource. '.php has no visible columns.'"
    :dataset="FilamentResourceTestsCommand::getVisibleColumns($table)"
>
    {{ $resource_model  }}::factory()->count(3)->create();

    livewire(App\Filament\Resources\{{$resource}}\Pages\List{{$resource_model_plural}}::class)->assertCanRenderTableColumn($column);
</x-filament-resource-tests::test-skeleton>

<x-filament-resource-tests::test-skeleton
    description="can sort column"
    :skip_reason="$resource. '.php has no sortable columns.'"
    :dataset="FilamentResourceTestsCommand::getSortableColumns($table)"
>
    $records = {{ $resource_model  }}::factory()->count(3)->create();

    livewire(App\Filament\Resources\{{$resource}}\Pages\List{{$resource_model_plural}}::class)
        ->sortTable($column)
        ->assertCanSeeTableRecords($records->sortBy($column), inOrder: true)
        ->sortTable($column, 'desc')
        ->assertCanSeeTableRecords($records->sortByDesc($column), inOrder: true);
</x-filament-resource-tests::test-skeleton>

<x-filament-resource-tests::test-skeleton
    description="can search column"
    :skip_reason="$resource. '.php has no searchable columns.'"
    :dataset="FilamentResourceTestsCommand::getSearchableColumns($table)"
>
    $records = {{ $resource_model  }}::factory()->count(3)->create();

    $search = $records->first()->{$column};

    livewire(App\Filament\Resources\{{$resource}}\Pages\List{{$resource_model_plural}}::class)
        ->searchTable($search)
        ->assertCanSeeTableRecords($records->where($column, $search))
        ->assertCanNotSeeTableRecords($records->where($column, '!=', $search));
</x-filament-resource-tests::test-skeleton>

<x-filament-resource-tests::test-skeleton
    description="can individually search column"
    :skip_reason="$resource. '.php has no individually searchable columns.'"
    :dataset="FilamentResourceTestsCommand::getIndividuallySearchableColumns($table)"
>
    $records = {{ $resource_model  }}::factory()->count(3)->create();

    $search = $records->first()->{$column};

    livewire(App\Filament\Resources\{{$resource}}\Pages\List{{$resource_model_plural}}::class)
        ->searchTableColumns([$column => $search])
        ->assertCanSeeTableRecords($records->where($column, $search))
        ->assertCanNotSeeTableRecords($records->where($column, '!=', $search));
</x-filament-resource-tests::test-skeleton>

@if($resource_model_uses_soft_deletes)
    <x-filament-resource-tests::test-skeleton
        description="cannot display trashed records by default"
        :allow_empty_dataset="true"
    >
        $records = {{ $resource_model }}::factory()->count(3)->create();

        $trashedRecords = {{ $resource_model }}::factory()->count(6)->trashed()->create();

        livewire(App\Filament\Resources\{{$resource}}\Pages\List{{$resource_model_plural}}::class)
            ->assertCanSeeTableRecords($records)
            ->assertCanNotSeeTableRecords($trashedRecords)
            ->assertCountTableRecords(3);
    </x-filament-resource-tests::test-skeleton>
@endif
