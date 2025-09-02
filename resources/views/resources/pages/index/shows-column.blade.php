it('shows `:dataset` column', function (string $column): void {
    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnVisible($column);
})->with([@foreach ($getResourceVisibleTableColumnKeys() as $column)'{{ $column }}',@endforeach]);
