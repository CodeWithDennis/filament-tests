it('cannot display trashed records by default', function (): void {
    $records = {{ $getResourceModel() }}::factory()->count(4)->create();
    $trashedRecords = {{ $getResourceModel() }}::factory()->trashed()->count(6)->create();

    livewire({{ $getPageClass('index') }}::class)
        @if($isResourceTableLoadingDeferred())->loadTable()
        @endif
        ->assertCanSeeTableRecords($records)
        ->assertCanNotSeeTableRecords($trashedRecords)
        ->assertCountTableRecords(4);
});
