it('can render the index page', function (): void {
    livewire({{ $livewireClass }}::class)
        ->assertOk();
});
