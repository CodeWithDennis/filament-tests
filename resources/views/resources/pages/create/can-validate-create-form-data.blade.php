it('validates form data field :dataset', function (array $data, array $errors): void {
    $record = {{ $getResourceModel() }}::factory()->make();

    livewire({{ $getPageClass('create') }}::class)
        ->fillForm([
            ...$data
        ])
        ->call('create')
        ->assertHasFormErrors($errors)
        ->assertNotified();
})->with([
    @foreach($getResourceRequiredFormFields() as $key => $field)
    '`{{ $key }}` is required' => [['{{ $key }}' => null], ['{{ $key }}' => 'required']],
    @endforeach
    @foreach($getResourceMaxLengthFormFields() as $key => $field)
        '`{{ $key }}` is max {{ $field->getMaxLength() }} characters' => [['{{ $key }}' => Illuminate\Support\Str::random({{ $field->getMaxLength() + 1 }})], ['{{ $key }}' => 'max']],
    @endforeach
]);
