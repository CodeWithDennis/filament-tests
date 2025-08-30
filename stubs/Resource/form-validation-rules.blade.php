describe('validation', function (): void {
    it('validates the form data', function (array $data, array $errors): void {
        $record = {{ $modelClass }}::factory()->create();
        $newRecordData = {{ $modelClass }}::factory()->make();

        livewire({{ $editPageClass }}::class, ['record' => $record->id])
            ->fillForm([
                'name' => $newRecordData->name,
                ...$data,
            ])
            ->call('save')
            ->assertHasFormErrors($errors)
            ->assertNotNotified();
    })->with([
        '`name` is required' => [['name' => null], ['name' => 'required']],
        '`name` is max 255 characters' => [['name' => Str::random(256)], ['name' => 'max']],
        '`description` is max 255 characters' => [['description' => Str::random(256)], ['description' => 'max']],
    ]);
});