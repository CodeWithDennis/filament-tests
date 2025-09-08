it('can search `:dataset` column', function (string $column): void {
    $records = {{ $getResourceModel() }}::factory(3)->create();
    $search = data_get($records->first(), $column);

    livewire({{ $getPageClass('index') }}::class)
        @if($isResourceTableLoadingDeferred())->loadTable()
        @endif
        ->searchTable($search instanceof BackedEnum ? $search->value : $search)
        ->assertCanSeeTableRecords($records->filter(fn (Illuminate\Database\Eloquent\Model $record) => data_get($record, $column) == $search))
        ->assertCanNotSeeTableRecords($records->filter(fn (Illuminate\Database\Eloquent\Model $record) => data_get($record, $column) != $search));
})->with([@foreach ($getResourceTableSearchableColumnKeys() as $column)'{{ $column }}',@endforeach]);
