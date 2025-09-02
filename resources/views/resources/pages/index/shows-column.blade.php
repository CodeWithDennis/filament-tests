it('shows `:dataset` column', function (string $column): void {
    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnVisible($column);
})->with([@foreach ($getResourceTableVisibleColumnKeys() as $column)'{{ $column }}',@endforeach]);
