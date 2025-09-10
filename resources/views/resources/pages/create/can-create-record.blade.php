@php use Filament\Forms\Components\RichEditor; @endphp
it('can create a record', function (): void {
    $record = {{ $getResourceModel() }}::factory()->make();

    livewire({{ $getPageClass('create') }}::class)
        ->fillForm([
            @foreach($getResourceFormFields() as $key => $field)
                @if($field instanceof RichEditor)
                    // TODO: RichEditor expects a very specific array structure for its data and Filament tests do not currently support this.
                    // '{{ $key }}' => $record->{{ $key }},
                @else
                '{{ $key }}' => $record->{{ $key }},
                @endif
            @endforeach
        ])
        ->call('create')
        ->assertNotified();

        $this->assertDatabaseHas({{ $getResourceModel() }}::class, [
            @foreach($getResourceFormFields() as $key => $field)
                @if($field instanceof RichEditor)
                    // TODO: RichEditor expects a very specific array structure for its data and Filament tests do not currently support this.
                    // '{{ $key }}' => $record->{{ $key }},
                @else
                '{{ $key }}' => $record->{{ $key }},
                @endif
            @endforeach
        ]);
});
