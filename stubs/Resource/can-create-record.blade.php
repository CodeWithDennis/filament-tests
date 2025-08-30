it('can create a record', function (): void {
$record = {{ $modelClass }}::factory()->make();
$image = UploadedFile::fake()->image('gold.jpg');

livewire({{ $createPageClass }}::class)
->fillForm([
'name' => $record->name,
'description' => $record->description,
'image' => $image,
])
->call('create')
->assertNotified();

assertDatabaseHas({{ $modelClass }}, [
'name' => $record->name,
'description' => $record->description,
'image' => 'images/badges/'.str($record->name)->slug().'-badge-gold.jpg',
]);
});