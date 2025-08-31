it('can render the index page', function (): void {
livewire({{ $getResourceClass() }}::class)
->assertOk();
})@if($isTodo())
    ->todo{!! $getTodoMessage() ? "('{$getTodoMessage()}')" : '()' !!}
@endif;
