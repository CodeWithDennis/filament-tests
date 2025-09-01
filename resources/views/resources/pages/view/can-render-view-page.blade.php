it('can render the view page', function (): void {
    livewire({{ $getPageClass('view') }}::class)
        ->assertOk();
});
