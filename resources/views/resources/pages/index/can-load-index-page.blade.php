it('can load the index page', function (): void {
    ${{ $getResourceModelNamePlural() }} = {{ $getResourceModel() }}::factory(5)->create();

    livewire({{ $getPageClass('index') }}::class)
        ->assertCanSeeTableRecords(${{ $getResourceModelNamePlural() }});
});
