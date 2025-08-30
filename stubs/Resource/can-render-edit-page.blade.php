it('can render the edit page', function (): void {
    $record = {{ $modelClass }}::factory()->create();

    livewire({{ $editPageClass }}::class, ['record' => $record->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'name' => $record->name,
            'description' => $record->description,
            'image' => $record->image,
        ]);
});