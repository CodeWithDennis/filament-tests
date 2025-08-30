it('can render the view page', function (): void {
    $record = {{ $modelClass }}::factory()->create();

    livewire({{ $viewPageClass }}::class, ['record' => $record->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'name' => $record->name,
            'description' => $record->description,
            'image' => $record->image,
        ]);
});
