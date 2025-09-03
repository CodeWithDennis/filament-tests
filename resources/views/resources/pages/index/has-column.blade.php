it('has `:dataset` column', function (string $column): void {
    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnExists($column);
})->with([@foreach ($getResourceTableColumnKeys() as $column)'{{ $column }}',@endforeach]);
