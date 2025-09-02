it('cannot render `:dataset` column', function (string $column): void {
    livewire({{ $getPageClass('index') }}::class)
        ->assertCanNotRenderTableColumn($column);
})->with([@foreach ($getResourceInitiallyHiddenTableColumnKeys() as $column)'{{ $column }}',@endforeach]);
