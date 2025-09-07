it('can delete a record', function (): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getPageClass('edit') }}::class, ['record' => $record->getKey()])
        ->callAction(Filament\Actions\DeleteAction::class)
        ->assertNotified()
        ->assertRedirect();

    Pest\Laravel\assertDatabaseMissing($record);
});
