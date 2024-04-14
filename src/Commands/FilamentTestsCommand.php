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

    protected ?Collection $selectedResources;

    protected ?Collection $skippedResources;

    protected ?Collection $failedResources;

    protected ?Collection $todos;

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();

        $this->selectedResources = collect();
        $this->skippedResources = collect();
        $this->failedResources = collect();
        $this->todos = collect();
    }

    public function stubHandler(Resource $resource): StubHandler
    {
        return new StubHandler($resource);
    }

    public function handle(): int
    {
        $this->numTests = 0;
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
            
            if (! $this->getResourceClass($selectedResource)) {
                $this->failedResources->push(['name' => $this->getNormalizedResourceName($selectedResource)]);

                continue;
            }

            $resource = $this->getResourceClass($selectedResource);

            $path = $this->getSourceFilePath($selectedResource);

            $this->files->ensureDirectoryExists(dirname($path));

            $contents = $this->getSourceFile($resource);

            if ($this->files->exists($path) && ! $this->option('force')) {
                if (! confirm("The test for {$selectedResource} already exists. Do you want to overwrite it?")) {
                    $this->skippedResources->push(['name' => $this->getNormalizedResourceName($selectedResource)]);

                    continue;
                }
            }

            $this->files->put($path, $contents);
        }

        $resources = collect([
            'selected' => $this->selectedResources,
            'skipped' => $this->skippedResources,
            'failed' => $this->failedResources,
            'todos' => $this->todos,
        ]);

        $this->tableOutput($resources);

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

        $resourceName = str($this->getNormalizedResourceName($resource::class))->afterLast('\\')->toString();

        $numTests = 0;
        $todos = collect();
        $countTodos = 0;
        $start = microtime(true);

        foreach ($this->getStubs($resource) as $stub) {
            if (is_null($stub)) {
                continue;
            }

            if (! $stub['isTodo']) {
                $numTests++;
            }

            if ($stub['isTodo']) {
                $todos->push($stub);
                $countTodos++;
            }

            $contents .= $this->getStubContents($stub['path'], $stub['variables']);
        }

        $end = microtime(true);

        $duration = round($end - $start, 3) * 1000;

        $this->selectedResources->push([
            'name' => $resourceName,
            'tests' => $numTests,
            'duration' => $duration,
        ]);

        if ($countTodos > 0) {
            $this->todos->push([
                'name' => $resourceName,
                'count' => $countTodos,
            ]);
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

    protected function getNormalizedResourceName(string $name): string
    {
        return str($name)->ucfirst()->finish('Resource');
    }

    protected function tableOutput(Collection $resources): void
    {
        // Remove skipped and failed resources from selected if they exist
        $resources['selected'] = $resources['selected']->reject(function ($item) use ($resources) {
            return $resources['skipped']->contains('name', $item['name']) || $resources['failed']->contains('name', $item['name']);
        })->filter();

        $resources['selected'] = $resources['selected']->map(function ($item) use ($resources) {

            $todoEntry = $resources['todos']->firstWhere('name', $item['name']);

            $item['todos'] = $todoEntry ? $todoEntry['count'] : 0;

            return $item;
        });

        // we need to unset otherwise a new section will be created for "todos"
        unset($resources['todos']);

        $totals = [
            'tests' => $resources['selected']->sum('tests'),
            'todos' => $resources['selected']->sum('todos'),
            'duration' => $resources['selected']->sum(function ($item) {
                return (int) str_replace('ms', '', $item['duration']);
            }),
        ];

        $resources->each(function ($items, $status) {

            $color = match ($status) {
                'selected' => 'green',
                'skipped' => 'yellow',
                'failed' => 'red',
                default => 'default',
            };

            $statusHeading = match ($status) {
                'selected' => 'SUCCESS',
                'skipped' => 'SKIPPED',
                'failed' => 'FAILED',
                default => 'UNKNOWN',
            };

            $items->each(function ($item) use ($status, $color, $statusHeading) {
                $this->newLine();

                $this->components->twoColumnDetail('<fg='.$color.';options=bold>'.$item['name'].'</>', '<fg='.$color.';options=bold>'.$statusHeading.'</>');

                if ($status === 'selected') {
                    $this->components->twoColumnDetail('No. of Test(s)', $item['tests']);

                    if ($item['todos'] > 0) {
                        $this->components->twoColumnDetail('No. of Todo(s)', '<fg=cyan>'.$item['todos'].'</>');
                    }

                    $this->components->twoColumnDetail('Duration', $item['duration'].'ms');
                }
            });

        });

        // summary
        $this->newLine();

        $totalDuration = $totals['duration'] > 1000 ? number_format($totals['duration'] / 1000, 2).'s' : $totals['duration'].'ms';

        $this->components->twoColumnDetail('<options=bold>Total</>');
        $this->components->twoColumnDetail('No. of Resource(s)', $resources['selected']->count());
        $this->components->twoColumnDetail('No. of Test(s)', $totals['tests']);

        if ($totals['todos'] > 0) {
            $this->components->twoColumnDetail('No. of Todo(s)', '<fg=cyan>'.$totals['todos'].'</>');
        }

        if ($resources['skipped']->count() > 0) {
            $this->components->twoColumnDetail('No. of Skipped Resources', '<fg=yellow>'.$resources['skipped']->count().'</>');
        }

        if ($resources['failed']->count() > 0) {
            $this->components->twoColumnDetail('No. of Failed Resources', '<fg=red>'.$resources['failed']->count().'</>');
        }

        $this->components->twoColumnDetail('Duration', $totalDuration);
    }
}
