<?php

namespace CodeWithDennis\FilamentTests\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class FilamentTestsCreateStubCommand extends Command
{
    protected $signature = 'make:filament-test-stub
                            {name : The name of the stub}
                            {description : The description of the stub}
                            {--t|todo : Generate as todo}
                            {--f|force : Force overwrite the existing stub}';

    protected $description = 'Create a new stub';

    protected ?string $emoji = null;

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
        $this->selectRandomEmoji();
    }

    public function handle(): int
    {
        $this->generateStub();

        return self::SUCCESS;
    }

    protected function generateStub(): array
    {
        $name = $this->argument('name');
        $description = $this->argument('description');
        $isTodoStub = $this->option('todo');

        $normalizedPath = collect(explode('.', $name))
            ->map(fn ($part) => collect(explode('/', $part))
                ->map(fn ($subPart) => ucfirst($subPart))
                ->implode(DIRECTORY_SEPARATOR)
            );

        $className = ucfirst($normalizedPath->pop());

        $stubsBasePath = realpath(__DIR__.'/../../stubs');
        $stubsCurrentPath = $stubsBasePath;
        $classesBasePath = realpath(__DIR__.'/../Stubs');
        $classesCurrentPath = $classesBasePath;

        $normalizedPath->each(function ($part) use (&$stubsCurrentPath, &$classesCurrentPath) {
            $stubsCurrentPath .= DIRECTORY_SEPARATOR.$part;
            $classesCurrentPath .= DIRECTORY_SEPARATOR.$part;
            $this->files->ensureDirectoryExists($stubsCurrentPath);
            $this->files->ensureDirectoryExists($classesCurrentPath);
        });

        $stubTemplateFile = $stubsBasePath.DIRECTORY_SEPARATOR.($isTodoStub ? '_todo.stub' : '_stub.stub');
        $classTemplateFile = $stubsBasePath.DIRECTORY_SEPARATOR.($isTodoStub ? '_todo.class' : '_stub.class');

        $stubFile = $stubsCurrentPath.DIRECTORY_SEPARATOR.$className.'.stub';
        $this->createFileFromTemplate($stubFile, $stubTemplateFile, $description, $className, false);

        $classFile = $classesCurrentPath.DIRECTORY_SEPARATOR.$className.'.php';
        $this->createFileFromTemplate($classFile, $classTemplateFile, $description, $className, true);

        return collect([$name, $description])->all();
    }

    protected function selectRandomEmoji(): void
    {
        $randomEmoji = collect(['🚀', '🔥', '🌟', '🎉', '👍', '👏', '🙌', '💪', '🤝', '👀', '🔖']);
        $this->emoji = $randomEmoji->random();
    }

    protected function createFileFromTemplate($filePath, $templatePath, $description, $className, $isClassFile): void
    {
        $content = $this->files->get($templatePath);
        $content = str_replace('{{ DESCRIPTION }}', $description, $content);

        if ($isClassFile) {
            $content = str_replace('{{ NAME }}', $className, $content);

            $namespacePath = str_replace([realpath(__DIR__.'/../Stubs'), DIRECTORY_SEPARATOR], ['', '\\'], dirname($filePath));
            $namespace = trim('CodeWithDennis\FilamentTests\Stubs'.$namespacePath, '\\');
            $content = str_replace('{{ NAMESPACE }}', 'namespace '.$namespace.';', $content);

            if (str_contains($content, '{{ IMPORT_CLOSURE }}')) {
                $content = str_replace('{{ IMPORT_CLOSURE }}', 'use Closure;', $content);
            }
        }

        if ($this->files->exists($filePath) && ! $this->option('force')) {
            if (! $this->confirm("The {$filePath} file already exists. Do you want to overwrite it?")) {
                return;
            }
        }

        $this->files->put($filePath, $content);
        $this->info("File created: {$filePath} {$this->emoji}");
    }
}
