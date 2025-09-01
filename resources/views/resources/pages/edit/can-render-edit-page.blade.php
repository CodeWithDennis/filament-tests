it('can render the edit page', function (): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getPageClass('edit') }}::class, ['record' => $record->id])
    ->assertOk();
});
