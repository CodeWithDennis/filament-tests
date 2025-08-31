it('can render the index page', function (): void {
livewire({{ $getIndexPageClass() }}::class)
->assertOk();
})@if($isTodo())
    ->todo{!! $getTodoMessage() ? "('{$getTodoMessage()}')" : '()' !!}
@endif
@if($getShouldSkip())
    ->skip{!! $getSkipMessage() ? "('{$getSkipMessage()}')" : '()' !!}
@endif;
