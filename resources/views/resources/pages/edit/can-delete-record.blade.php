it('can delete a record', function (): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getPageClass('edit') }}::class, ['record' => $record->id])
        ->callAction(Filament\Actions\DeleteAction::class)
        ->assertNotified()
        ->assertRedirect();

    @if($getResourceModelHasSoftDeletes())
        Pest\Laravel\assertSoftDeleted($record);
        @else
        Pest\Laravel\assertDatabaseMissing($record);
    @endif
});
