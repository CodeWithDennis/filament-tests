it('can render the edit page', function (): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getResourceClass() }}::class, ['record' => $record->id])
    ->assertOk();
});
