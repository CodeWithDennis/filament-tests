test('`:dataset` column has the extra attributes', function (string $column, array $attributes): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnHasExtraAttributes($column, $attributes, $record);
})->with([
@foreach ($getResourceTableColumnsWithExtraAttributes() as $column)
    ['{{ $column->getName() }}',
        {!! var_export($column->getExtraAttributes(), true) !!}
    ],
@endforeach
]);
