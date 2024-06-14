<?php

    namespace CodeWithDennis\FilamentTests\Commands;

    use Illuminate\Console\Command;
    use Illuminate\Filesystem\Filesystem;
    use ReflectionClass;

    class ListTodosCommand extends Command
    {
        protected $signature = 'make:filament-test-todo-list';
        protected $description = '(internal) Output a list of todos for Filament tests';

        protected Filesystem $files;

        public function __construct(Filesystem $files)
        {
            parent::__construct();
            $this->files = $files;
        }

        public function handle(): int
        {
            $files = $this->files->allFiles(__DIR__ . '/../Stubs');
            $todos = collect($files)
                ->map(fn($file) => $this->getClassFromFile($file->getPathname()))
                ->filter(fn($class) => $class && $this->hasTodoProperty($class))
                ->values()
                ->all();

            $this->outputTodos($todos);

            return self::SUCCESS;
        }

        protected function getClassFromFile(string $filePath): ?string
        {
            $contents = $this->files->get($filePath);
            $namespace = $this->getNamespaceFromFile($contents);
            $className = $this->getClassNameFromFile($contents);

            return $namespace && $className ? $namespace . '\\' . $className : null;
        }

        protected function getNamespaceFromFile(string $fileContents): ?string
        {
            return str($fileContents)->match('/namespace\s+(.+?);/') ?: null;
        }

        protected function getClassNameFromFile(string $fileContents): ?string
        {
            return str($fileContents)->match('/class\s+(\w+)/') ?: null;
        }

        protected function hasTodoProperty(string $class): bool
        {
            if (!class_exists($class)) {
                return false;
            }

            $reflection = new ReflectionClass($class);
            if ($reflection->hasProperty('isTodo')) {
                $property = $reflection->getProperty('isTodo');
                $instance = $reflection->newInstanceWithoutConstructor();
                return $property->getValue($instance) === true;
            }

            return false;
        }

        protected function outputTodos(array $todos): void
        {
            $this->table(['Todos ' . count($todos)], collect($todos)->map(function ($todo) {
                $todo = str($todo)->trim('CodeWithDennis\FilamentTests\Stubs\\');
                return [$todo];
            })->all());
        }
    }
