it('has `:dataset` filter', function (string $filter): void {
    livewire({{ $getPageClass('index') }}::class)
        ->assertTableFilterExists($filter);
})->with([@foreach ($getResourceTableFilters() as $filter)'{{ $filter->getName() }}',@endforeach
]);
