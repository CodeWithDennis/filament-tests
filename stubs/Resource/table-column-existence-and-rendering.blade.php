it('has column', function (string $column): void {
livewire({{ $listPageClass }}::class)
->assertTableColumnExists($column);
})->with(['name', 'description', 'image', 'created_at', 'updated_at']);

it('can render column', function (string $column): void {
livewire({{ $listPageClass }}::class)
->assertCanRenderTableColumn($column);
})->with(['name', 'description', 'image', 'created_at', 'updated_at']);