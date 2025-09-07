it('`:dataset` column has the correct formatted state', function (string $column): void {
    $records = {{ $getResourceModel() }}::factory(3)->create();

    $record = $records->first();

    $value = data_get($record, $column);

//     if ($value instanceof Carbon\Carbon || $value instanceof Carbon\CarbonImmutable ) {
//        $value = $value->format('Y-m-d H:i:s');
//     }

    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnFormattedStateSet($column, $value, record: $record)
        ->assertTableColumnFormattedStateNotSet($column, 'non-existent-value', record: $record);
{{-- TODO: support all column types --}}
})->with([@foreach ($getResourceTableTextColumnKeys() as $column)'{{ $column }}',@endforeach])
@if(count($diff = array_diff($getResourceTableVisibleColumnKeys(), $getResourceTableTextColumnKeys())) > 0)
    ->todo('The following columns were skipped during generation as their state could not be determined automatically: {{ implode(", ", $diff) }}')
@endif
    ->skip('This test requires additional attention because the formatted state is likely to differ from the raw state.');
