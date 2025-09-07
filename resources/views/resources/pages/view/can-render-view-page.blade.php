it('can render the view page', function (): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getPageClass('view') }}::class, ['record' => $record->getKey()])
        ->assertOk();
});
