test('`:dataset` column has the correct description below', function (string $column, string $content): void {
    $records = {{ $getResourceModel() }}::factory(10)->create();

    $record = $records->first();

    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnHasDescription($column, $content, $record, 'below');
})->with([
@foreach ($getResourceTableTextColumnsWithDescriptionBelow()->mapWithKeys(fn (Filament\Tables\Columns\TextColumn $column) => [$column->getName() => $column->getDescriptionBelow()]) as $column => $content)
    ['{{ $column }}', '{{ $content }}'],
@endforeach
]);
