it('can bulk delete records', function (): void {
    $records = {{ $getResourceModel() }}::factory(5)->create();

    livewire({{ $getPageClass('index') }}::class)
        @if($isResourceTableLoadingDeferred())->loadTable()
        @endif
        ->assertCanSeeTableRecords($records)
        ->selectTableRecords($records)
        ->callAction(Filament\Actions\Testing\TestAction::make(Filament\Actions\DeleteBulkAction::class)->table()->bulk())
        ->assertNotified()
        ->assertCanNotSeeTableRecords($records);

    @if($getResourceModelHasSoftDeletes())
        $this->assertSoftDeleted($records);
    @else
        $this->assertDatabaseMissing($records);
    @endif
});
