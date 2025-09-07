it('can paginate records', function (): void {
    $records = {{ $getResourceModel() }}::factory({{ $factoryCount = $getResourceTableDefaultPaginationPageOption() * 2 }})->create();

    livewire({{ $getPageClass('index') }}::class)
        @if($isResourceTableLoadingDeferred())->loadTable()
        @endif
        ->assertCanSeeTableRecords($records->take({{ $factoryCount / 2 }}), inOrder: true)
        ->call('gotoPage', 2)
        @if($isResourceTableLoadingDeferred())->loadTable()
        @endif
        ->assertCanSeeTableRecords($records->skip({{ $factoryCount / 2 }})->take({{ $factoryCount / 2 }}), inOrder: true);
});
