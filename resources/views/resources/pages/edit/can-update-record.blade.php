it('can update a record', function (): void {
    $record = {{ $getResourceModel() }}::factory()->create();
    $newRecord = {{ $getResourceModel() }}::factory()->make();

    livewire({{ $getPageClass('edit') }}::class, ['record' => $record->getKey()])
        ->fillForm([
            @foreach($getResourceFormFields() as $key => $field)
                '{{ $key }}' => $newRecord->{{ $key }},
            @endforeach
        ])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertNotified();

        $this->assertDatabaseHas({{ $getResourceModel() }}::class, [
            @foreach($getResourceFormFields() as $key => $field)
                '{{ $key }}' => $newRecord->{{ $key }},
            @endforeach
        ]);
});
