it('can render the create page', function (): void {
    livewire({{ $getResourceClass() }}::class)
        ->assertOk();
});
