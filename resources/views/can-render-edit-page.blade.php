it('can render the edit page', function (): void {
$record = {{ $resourceClass }}::getModel()::factory()->create();

livewire({{ $resourceClass }}::class, ['record' => $record->id])
->assertOk();
});