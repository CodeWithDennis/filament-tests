it('hides `:dataset` column', function (string $column): void {
    livewire({{ $getPageClass('index') }}::class)
        ->assertTableColumnHidden($column);
})->with([@foreach ($getResourceHiddenTableColumnKeys() as $column)'{{ $column }}',@endforeach]);
