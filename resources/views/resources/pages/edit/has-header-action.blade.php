it('has `:dataset` header action', function (string $action): void {
    $record = {{ $getResourceModel() }}::factory()->create();

    livewire({{ $getPageClass('edit') }}::class, ['record' => $record->getKey()])
        ->assertActionExists(Filament\Actions\Testing\TestAction::make($action));
})->with([@foreach ($getPageHeaderActions('edit') as $action)'{{ $action->getName() }}',@endforeach]);
