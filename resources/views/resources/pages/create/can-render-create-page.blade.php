it('can render the create page', function (): void {
    livewire({{ $getPageClass('create') }}::class)
        ->assertOk();
});
