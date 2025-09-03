it('can search `:dataset` column', function (string $column): void {
    $records = {{ $getResourceModel() }}::factory(3)->create();
    $value = $records->first()->{$column};

    livewire({{ $getPageClass('index') }}::class)
        @if($isResourceTableLoadingGloballyDeferred())->loadTable()@endif
        ->searchTable($value)
        ->assertCanSeeTableRecords($records->where($column, $value))
        ->assertCanNotSeeTableRecords($records->where($column, '!=', $value));
})->with([@foreach ($getResourceTableSearchableColumnKeys() as $column)'{{ $column }}',@endforeach]);
