it('`:dataset` column has the correct description below', function (string $column, string $content): void {
    $records = {{ $getResourceModel() }}::factory(10)->create();

    $record = $records->first();

    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnHasDescription($column, $content, $record, 'below');
})->with([
@foreach ($getResourceTableTextColumnsWithDescriptionBelowAndContent() as $column => $content)
    ['{{ $column }}', '{{ $content }}'],
@endforeach
]);
