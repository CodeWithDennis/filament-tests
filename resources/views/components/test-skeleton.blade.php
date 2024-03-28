@props([
    'description' => null,
    'skip_reason' => 'Test has no dataset.',
    'dataset' => [],
    'dataset_key' => 'column',
    'resource' => null,
    'resource_model' => null,
    'resource_model_singular' => null,
    'resource_model_plural' => null,
    'resource_model_uses_soft_deletes' => false,
    'allow_empty_dataset' => false,
])

@once
{!! '<?php' !!}

use function Pest\Livewire\livewire;
@endonce

@if(empty($dataset) && !$allow_empty_dataset)
it('{{ $description }}')->skip('{{ $skip_reason }}');
@else
it('{{ $description }}', function({!! !empty($dataset) && $dataset_key ? '$' . $dataset_key : '' !!}) {
@if($slot->isNotEmpty())
{!! $slot !!}
@endif
})@if(!$allow_empty_dataset && !empty($dataset))
->with([{!! "'" . implode("', '", $dataset) . "'" !!}])
@endif
;
@endif
