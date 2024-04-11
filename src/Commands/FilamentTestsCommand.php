<?php

namespace CodeWithDennis\FilamentTests\Commands;

use CodeWithDennis\FilamentTests\Handlers\StubHandler;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;

class FilamentTestsCommand extends Command
{
    protected $signature = 'make:filament-test
                            {name? : The name of the resource}
                            {--a|all : Create tests for all Filament resources}
                            {--f|force : Force overwrite the existing test}';

    protected $description = 'Create a new test for a Filament component';

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    public function stubHandler(Resource $resource): StubHandler
    {
        return new StubHandler($resource);
    }

    public function handle(): int
    {
        $availableResources = $this->getAvailableResources();

        if (! $this->argument('name')) {
            $selectedResources = ! $this->option('all') ? multiselect(
                label: 'What is the resource you would like to create this test for?',
                options: $availableResources->flatten(),
                required: true,
            ) : $availableResources->flatten();

            // Check if the first selected item is numeric (on windows without WSL multiselect returns an array of numeric strings)
            if (is_numeric($selectedResources[0] ?? null)) {
                // Convert the indexed selection back to the original resource path => resource name
                $selectedResources = collect($selectedResources)
                    ->mapWithKeys(fn ($index) => [
                        $availableResources->keys()->get($index) => $availableResources->get($availableResources->keys()->get($index)),
                    ]);
            }
        } else {
            $suppliedResourceName = $this->getNormalizedResourceName($this->argument('name'));

            if (! $availableResources->contains($suppliedResourceName)) {
                $this->error("The resource {$suppliedResourceName} does not exist.");

                return self::FAILURE;
            }

            $selectedResources = [$availableResources->search($suppliedResourceName) => $suppliedResourceName];
        }

        foreach ($selectedResources as $selectedResource) {
            $resource = $this->getResourceClass($selectedResource);

            $path = $this->getSourceFilePath($selectedResource);

            $this->files->ensureDirectoryExists(dirname($path));

            $contents = $this->getSourceFile($resource);

            if ($this->files->exists($path) && ! $this->option('force')) {
                if (! confirm("The test for {$selectedResource} already exists. Do you want to overwrite it?")) {
                    continue;
                }
            }

            $this->files->put($path, $contents);

            $this->info("Test for {$selectedResource} created successfully.");
        }

        return self::SUCCESS;
    }

    protected function getStubPath(string $for, ?string $in = null): string
    {
        $basePath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'stubs';

        return $in
            ? $basePath.DIRECTORY_SEPARATOR.$in.DIRECTORY_SEPARATOR.$for.'.stub'
            : $basePath.DIRECTORY_SEPARATOR.$for.'.stub';
    }

    protected function getStubs(Resource $resource): Collection
    {
        $handler = $this->stubHandler($resource);

        return $handler->getStubs();
    }

    protected function getResources(): Collection
    {
        return collect(Filament::getResources());
    }

    protected function getResourceClass(string $resource): ?Resource
    {
        $match = $this->getResources()
            ->first(fn ($value): bool => str_contains($value, $resource) && class_exists($value));

        return $match ? app()->make($match) : null;
    }

    protected function getAvailableResources(): Collection
    {
        return $this->getResources()->map(fn ($resource): string => str($resource)->afterLast('Resources\\'));
    }

    protected function getSourceFilePath(string $name): string
    {
        $directory = trim(config('filament-tests.directory_name'), '/');

        if (config('filament-tests.separate_tests_into_folders')) {
            $directory .= DIRECTORY_SEPARATOR.$name;
        }

        return $directory.DIRECTORY_SEPARATOR.$name.'Test.php';
    }

    protected function getSourceFile(Resource $resource): array|bool|string
    {
        $contents = '';

        foreach ($this->getStubs($resource) as $stub) {
            if (is_null($stub)) continue;

            $contents .= $this->getStubContents($stub['path'], $this->getStubVariables($resource, $stub['path']));
        }

        return $contents;
    }

    protected function getStubContents(string $stub, array $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = preg_replace("/\{\{\s*{$search}\s*}}/", $replace, $contents);
        }

        return $contents.PHP_EOL;
    }

    protected function getStubVariables(Resource $resource): array
    {
        $variables = [];

        foreach ($this->getStubs($resource) as $stub) {
            if (is_null($stub)) continue;

            foreach ($stub['variables'] as $key => $value) {
                $variables[$key] = $value;
            }
        }

        return $variables;
    }

    protected function getNormalizedResourceName(string $name): string
    {
        return str($name)->ucfirst()->finish('Resource');
    }
}
