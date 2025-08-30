use App\Filament\Admin\Resources\Badges\Pages\CreateBadge;
use App\Filament\Admin\Resources\Badges\Pages\EditBadge;
use App\Filament\Admin\Resources\Badges\Pages\ListBadges;
use App\Filament\Admin\Resources\Badges\Pages\ViewBadge;
use App\Models\Badge;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

it('can render the index page', function (): void {
    livewire({{ $livewireClass }})
        ->assertOk();
});

it('can render the create page', function (): void {
    livewire(CreateBadge::class)
        ->assertOk();
});

it('can render the view page', function (): void {
    $record = Badge::factory()->create();

    livewire(ViewBadge::class, ['record' => $record->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'name' => $record->name,
            'description' => $record->description,
            'image' => $record->image,
        ]);
});

it('can render the edit page', function (): void {
    $record = Badge::factory()->create();

    livewire(EditBadge::class, ['record' => $record->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'name' => $record->name,
            'description' => $record->description,
            'image' => $record->image,
        ]);
});

it('has column', function (string $column): void {
    livewire(ListBadges::class)
        ->assertTableColumnExists($column);
})->with(['name', 'description', 'image', 'created_at', 'updated_at']);

it('can render column', function (string $column): void {
    livewire(ListBadges::class)
        ->assertCanRenderTableColumn($column);
})->with(['name', 'description', 'image', 'created_at', 'updated_at']);

it('can sort column', function (string $column): void {
    $records = Badge::factory(5)->create();

    livewire(ListBadges::class)
        ->loadTable()
        ->sortTable($column)
        ->assertCanSeeTableRecords($records->sortBy($column), inOrder: true)
        ->sortTable($column, 'desc')
        ->assertCanSeeTableRecords($records->sortByDesc($column), inOrder: true);
})->with(['name', 'created_at', 'updated_at']);

it('can search column', function (string $column): void {
    $records = Badge::factory(5)->create();
    $value = $records->first()->{$column};

    livewire(ListBadges::class)
        ->loadTable()
        ->searchTable($value)
        ->assertCanSeeTableRecords($records->where($column, $value))
        ->assertCanNotSeeTableRecords($records->where($column, '!=', $value));
})->with(['name']);

it('can create a record', function (): void {
    $record = Badge::factory()->make();
    $image = UploadedFile::fake()->image('gold.jpg');

    livewire(CreateBadge::class)
        ->fillForm([
            'name' => $record->name,
            'description' => $record->description,
            'image' => $image,
        ])
        ->call('create')
        ->assertNotified();

    assertDatabaseHas(Badge::class, [
        'name' => $record->name,
        'description' => $record->description,
        'image' => 'images/badges/'.str($record->name)->slug().'-badge-gold.jpg',
    ]);
});

it('can update a record', function (): void {
    $record = Badge::factory()->create();
    $newRecordData = Badge::factory()->make();
    $newRecordImage = UploadedFile::fake()->image('silver.jpg');

    livewire(EditBadge::class, ['record' => $record->id])
        ->fillForm([
            'name' => $newRecordData->name,
            'description' => $newRecordData->description,
            'image' => $newRecordImage,
        ])
        ->call('save')
        ->assertNotified();

    assertDatabaseHas(Badge::class, [
        'id' => $record->id,
        'name' => $newRecordData->name,
        'description' => $newRecordData->description,
        'image' => 'images/badges/'.str($newRecordData->name)->slug().'-badge-silver.jpg',
    ]);
});

describe('validation', function (): void {
    it('validates the form data', function (array $data, array $errors): void {
        $record = Badge::factory()->create();
        $newRecordData = Badge::factory()->make();

        livewire(EditBadge::class, ['record' => $record->id])
            ->fillForm([
                'name' => $newRecordData->name,
                ...$data,
            ])
            ->call('save')
            ->assertHasFormErrors($errors)
            ->assertNotNotified();
    })->with([
        '`name` is required' => [['name' => null], ['name' => 'required']],
        '`name` is max 255 characters' => [['name' => Str::random(256)], ['name' => 'max']],
        '`description` is max 255 characters' => [['description' => Str::random(256)], ['description' => 'max']],
    ]);
});

describe('actions', function (): void {
    it('can delete a record', function (): void {
        $record = Badge::factory()->create();

        livewire(EditBadge::class, ['record' => $record->id])
            ->callAction(DeleteAction::class)
            ->assertNotified()
            ->assertRedirect();

        assertDatabaseMissing($record);
    });

    it('can bulk delete records', function (): void {
        $records = Badge::factory(3)->create();

        livewire(ListBadges::class)
            ->loadTable()
            ->assertCanSeeTableRecords($records)
            ->selectTableRecords($records)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertNotified()
            ->assertCanNotSeeTableRecords($records);

        $records->each(fn (Badge $record) => assertDatabaseMissing($record));
    });
});
