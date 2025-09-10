it(':dataset header action is hidden', function (string $action): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getPageClass('edit') }}::class, ['record' => $record->getKey()])
        ->assertActionHidden(Filament\Actions\Testing\TestAction::make($action));
})->with([@foreach ($getPageHeaderHiddenActions('edit') as $action)'{{ $action->getName() }}',@endforeach]);
