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
    @foreach($getResourceFormFieldsByRulePrefix('required') as $key => $field)
    '`{{ $key }}` is required' => [['{{ $key }}' => null], ['{{ $key }}' => 'required']],
    @endforeach
    @foreach($getResourceFormFieldsByRulePrefix('max') as $key => $field)
        '`{{ $key }}` is max {{ $getRuleValue($field, 'max') }} characters' => [['{{ $key }}' => Illuminate\Support\Str::random({{ $getRuleValue($field, 'max') + 1 }})], ['{{ $key }}' => 'max']],
    @endforeach
    @foreach($getResourceFormFieldsByRulePrefix('min') as $key => $field)
        '`{{ $key }}` is min {{ $getRuleValue($field, 'min') }} characters' => [['{{ $key }}' => Illuminate\Support\Str::random({{ $getRuleValue($field, 'min') - 1 }})], ['{{ $key }}' => 'min']],
    @endforeach
]);
