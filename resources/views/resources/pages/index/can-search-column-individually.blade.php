it('can search `:dataset` column individually', function (string $column): void {
    $records = {{ $getResourceModel() }}::factory(3)->create();
    $search = data_get($records->first(), $column);

    livewire({{ $getPageClass('index') }}::class)
        @if($isResourceTableLoadingDeferred())->loadTable()@endif
        ->searchTableColumns([$column => $search instanceof BackedEnum ? $search->value : $search])
        ->assertCanSeeTableRecords($records->filter(fn (Illuminate\Database\Eloquent\Model $record) => data_get($record, $column) == $search))
        ->assertCanNotSeeTableRecords($records->filter(fn (Illuminate\Database\Eloquent\Model $record) => data_get($record, $column) != $search));
})->with([@foreach ($getResourceTableIndividualSearchableColumnKeys() as $column)'{{ $column }}',@endforeach]);
