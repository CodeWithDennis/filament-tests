it('can render the create page', function (): void {
    livewire({{ $resourceClass }}::class)
        ->assertOk();
});
