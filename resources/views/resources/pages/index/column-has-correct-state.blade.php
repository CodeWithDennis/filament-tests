it('`:dataset` column has the correct state', function (string $column): void {
    $records = {{ $getResourceModel() }}::factory(3)->create();

    $record = $records->first();

    $value = data_get($record, $column);

    if ($value instanceof Carbon\Carbon || $value instanceof Carbon\CarbonImmutable ) {
        $value = $value->toDateTimeString();
    }

    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnStateSet($column, $value, record: $record)
        ->assertTableColumnStateNotSet($column, 'non-existent-value', record: $record);
})@if(count($diff = array_diff($getResourceTableVisibleColumnKeys(), $getResourceTableTextColumnKeys())) > 0)
    ->todo('The following columns were skipped during generation as their state could not be determined automatically: {{ implode(", ", $diff) }}')
@endif
{{-- TODO: support all column types --}}
->with([@foreach ($getResourceTableTextColumnKeys() as $column)'{{ $column }}',@endforeach]);
