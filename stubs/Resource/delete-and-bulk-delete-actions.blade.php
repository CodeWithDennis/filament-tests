describe('actions', function (): void {
    it('can delete a record', function (): void {
        $record = {{ $modelClass }}::factory()->create();

        livewire({{ $editPageClass }}::class, ['record' => $record->id])
            ->callAction(DeleteAction::class)
            ->assertNotified()
            ->assertRedirect();

        assertDatabaseMissing($record);
    });

    it('can bulk delete records', function (): void {
        $records = {{ $modelClass }}::factory(3)->create();

        livewire({{ $listPageClass }}::class)
            ->loadTable()
            ->assertCanSeeTableRecords($records)
            ->selectTableRecords($records)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanNotSeeTableRecords($records);

        $records->each(fn ($record) => assertDatabaseMissing($record));
    });
});