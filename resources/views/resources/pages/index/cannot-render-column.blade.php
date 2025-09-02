it('cannot render `:dataset` column', function (string $column): void {
    livewire({{ $getPageClass('index') }}::class)
        ->assertCanNotRenderTableColumn($column);
})->with([@foreach ($getResourceTableDefaultHiddenColumnKeys() as $column)'{{ $column }}',@endforeach]);
