it('can render the create page', function (): void {
livewire({{ $createPageClass }}::class)
->assertOk();
});