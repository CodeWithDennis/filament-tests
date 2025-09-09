it('`select-column :dataset` has the correct options', function (string $column, array $options): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getPageClass('index') }}::class)
        ->assertTableSelectColumnHasOptions($column, $options, $record);
})->with([
@foreach ($getResourceTableSelectColumns() as $column)
    ['{{ $column->getName() }}',
        {!! var_export($column->getOptions(), true) !!}
    ],
@endforeach
]);