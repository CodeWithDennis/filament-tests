it('can search column', function (string $column): void {
$records = {{ $modelClass }}::factory(5)->create();
$value = $records->first()->{$column};

livewire({{ $listPageClass }}::class)
->loadTable()
->searchTable($value)
->assertCanSeeTableRecords($records->where($column, $value))
->assertCanNotSeeTableRecords($records->where($column, '!=', $value));
})->with(['name']);