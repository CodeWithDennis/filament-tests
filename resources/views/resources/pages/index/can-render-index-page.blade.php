it('can render the index page', function (): void {
    livewire({{ $getPageClass('index') }}::class)
        ->assertOk();
});
