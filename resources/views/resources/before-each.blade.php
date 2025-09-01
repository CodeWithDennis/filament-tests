use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = {{ $getAuthenticatableModel() }}::factory()->create();

    actingAs($user);
});
