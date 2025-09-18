it('can create a record', function (): void {
    $record = {{ $getResourceModel() }}::factory()->make();

    livewire({{ $getPageClass('create') }}::class)
        ->fillForm([
            @foreach($getResourceFormFields() as $key => $field)
                '{{ $key }}' => $record->{{ $key }},
            @endforeach
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified();

        $this->assertDatabaseHas({{ $getResourceModel() }}::class, [
            @foreach($getResourceFormFields() as $key => $field)
                '{{ $key }}' => $record->{{ $key }},
            @endforeach
        ]);
});
