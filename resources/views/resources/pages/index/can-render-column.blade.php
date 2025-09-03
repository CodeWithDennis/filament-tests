it('can render `:dataset` column', function (string $column): void {
    livewire({{ $getPageClass('index') }}::class)
        ->assertCanRenderTableColumn($column);
})->with([@foreach ($getResourceTableDefaultVisibleColumnKeys() as $column)'{{ $column }}',@endforeach]);
