it('can sort column', function (string $column): void {
    $records = {{ $modelClass }}::factory(5)->create();

    livewire({{ $listPageClass }}::class)
        ->loadTable()
        ->sortTable($column)
        ->assertCanSeeTableRecords($records->sortBy($column), inOrder: true)
        ->sortTable($column, 'desc')
        ->assertCanSeeTableRecords($records->sortByDesc($column), inOrder: true);
})->with(['name', 'created_at', 'updated_at']);