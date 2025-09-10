test('`:dataset` column has the correct description above', function (string $column, string $content): void {
    $records = {{ $getResourceModel() }}::factory(10)->create();

    $record = $records->first();

    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnHasDescription($column, $content, $record, 'above');
})->with([
@foreach ($getResourceTableTextColumnsWithDescriptionAbove()->mapWithKeys(fn (Filament\Tables\Columns\TextColumn $column) => [$column->getName() => $column->getDescriptionAbove()]) as $column => $content)
    ['{{ $column }}', '{{ $content }}'],
@endforeach
]);
