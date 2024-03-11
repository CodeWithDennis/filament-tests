<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Stringable;
use function Laravel\Prompts\{text, select};

class FilamentResourceTestsCommand extends Command
{
    protected $signature = 'filament:make-test {name?}';

    protected $description = 'Create a new test for a Filament resource.';

    protected Filesystem $files;

    protected Stringable $argumentName;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    protected function getStubPath(): string
    {
        return __DIR__ . '/../../stubs/Resource.stub';
    }

    protected function getStubVariables(): array
    {
        $singularName = $this->argumentName->singular()->remove('resource', false);
        $pluralName = $this->argumentName->plural()->remove('resource', false);

        return [
            'resource' => $this->getResourceName(),
            'model' => $this->getModel(),
            'singular_name' => $singularName,
            'singular_name_lowercase' => $singularName->lower(),
            'plural_name' => $pluralName,
            'plural_name_lowercase' => $pluralName->lower(),
        ];
    }

    protected function getSourceFile(): array|bool|string
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    protected function getStubContents($stub, $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    protected function getSourceFilePath(): string
    {
        return base_path("tests/Feature/{$this->getResourceName()}Test.php");
    }

    protected function makeDirectory($path): string
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    protected function getModel(): ?string
    {
        return $this->getResourceClass()?->getModel();
    }

    protected function getResourceName(): ?string
    {
        return $this->argumentName->words()->endsWith('Resource') ?
            $this->argumentName->value() :
            $this->argumentName->value() . 'Resource';
    }

    protected function getResourceClass(): ?Resource
    {
        $match = collect(Filament::getResources())
            ->first(
                fn($resource): bool => str_contains($resource, $this->getResourceName()) && class_exists($resource)
            );

        return $match ? app()->make($match) : null;
    }

    protected function getResourceTableColumns()
    {
        // TODO: Get the table columns of the given filament resource
    }

    protected function getResourceSortableTableColumns()
    {
        // TODO: Get the table sortable columns of the given filament resource
    }

    protected function getResourceSearchableTableColumns()
    {
        // TODO: Get the table searchable columns of the given filament resource
    }

    protected function getResourceTableFilters()
    {
        // TODO: Get the table filters of the given filament resource
    }

    public function handle(): void
    {
        $panels = Filament::getPanels();

        /** @var \Filament\Panel $panel */
        $panel = (count($panels) > 1) ? $panels[select(
            label: 'Which panel would you like to create this in?',
            options: array_map(
                static fn(\Filament\Panel $panel): string => $panel->getId(),
                $panels,
            ),
            default: Filament::getDefaultPanel()->getId()
        )] : Arr::first($panels);

        $filamentResources = collect($panel->getResources())->map(
            static fn($resource): string => str($resource)->afterLast('Resources\\')
        );
        $resource = str(
            $this->argument('name') ?? select(
                label: 'What is the resource you would like to create this test for?',
                options: $filamentResources->flatten(),
                required: true,
            ),
        )
            ->studly()
            ->trim('/')
            ->trim('\\')
            ->trim(' ')
            ->replace('/', '\\')
            ->value();

        if (!str($resource)->endsWith('Resource')) {
            $resource .= 'Resource';
        }

        $this->argumentName = str($resource);

        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if ($this->files->exists($path)) {
            $this->warn("Test for {$this->getResourceName()} already exists.");

            return;
        }

        $this->files->put($path, $contents);
        $this->info("Test for {$this->getResourceName()} created successfully.");
    }
}
