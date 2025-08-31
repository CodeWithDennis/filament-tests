it('can render the index page', function (): void {
    livewire({{ $getIndexPageClass() }}::class)
        ->assertOk();
});
