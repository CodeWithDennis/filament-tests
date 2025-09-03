it('can sort `:dataset` column', function (string $column): void {
    $records = {{ $getResourceModel() }}::factory(3)->create();

    livewire({{ $getPageClass('index') }}::class)
        ->sortTable($column)
        ->assertCanSeeTableRecords($records->sortBy($column), inOrder: true)
        ->sortTable($column, 'desc')
        ->assertCanSeeTableRecords($records->sortByDesc($column), inOrder: true);
})->with([@foreach ($getResourceTableSortableColumnKeys() as $column)'{{ $column }}',@endforeach]);
