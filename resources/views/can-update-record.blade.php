it('can update a record', function (): void {
$record = {{ $modelClass }}::factory()->create();
$newRecordData = {{ $modelClass }}::factory()->make();
$newRecordImage = UploadedFile::fake()->image('silver.jpg');

livewire({{ $editPageClass }}::class, ['record' => $record->id])
->fillForm([
'name' => $newRecordData->name,
'description' => $newRecordData->description,
'image' => $newRecordImage,
])
->call('save')
->assertNotified();

assertDatabaseHas({{ $modelClass }}, [
'id' => $record->id,
'name' => $newRecordData->name,
'description' => $newRecordData->description,
'image' => 'images/badges/'.str($newRecordData->name)->slug().'-badge-silver.jpg',
]);
});