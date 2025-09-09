it(':dataset header action is visible', function (string $action): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getPageClass('edit') }}::class, ['record' => $record->getKey()])
        ->assertActionVisible(Filament\Actions\Testing\TestAction::make($action));
})->with([@foreach ($getPageHeaderVisibleActions('edit') as $action)'{{ $action->getName() }}',@endforeach]);
