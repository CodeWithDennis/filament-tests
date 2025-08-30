it('can render the edit page', function (): void {
    $record = {{ $resourceModel }}::factory()->create();

    livewire({{ $resourceClass }}::class, ['record' => $record->id])
    ->assertOk();
});
