<?php

namespace CodeWithDennis\FilamentResourceTests\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\text;
use function Laravel\Prompts\multiselect;

class FilamentResourceTestsCommand extends Command
{
    protected $signature = 'filament:test {resource?}';

    protected $description = 'My command';

    public function handle()
    {
        $resource = (string) str(
            $this->argument('resource') ?? text(
            label: 'What is the resource you would like to create tests for?',
            placeholder: 'DepartmentResource',
            required: true,
        ),
        )
            ->studly()
            ->trim('/')
            ->trim('\\')
            ->trim(' ')
            ->replace('/', '\\');

        if (!str($resource)->endsWith('Resource')) {
            $resource .= 'Resource';
        }

        $modelName = Str::of($resource)->remove('Resource');

        $options = [
            'Create',
            'Edit',
            'List',
            'View',
            'Sort',
            'Search',
            'Filter'
        ];

        $tests = multiselect(
            label: 'What tests would you like to create?',
            options: $options,
            default: $options,
            scroll: 10,
            required: true
        );


        // Sorting
        // Searching
        // Existence
        // Filters
        // Resetting filters
        // Removing Filters


        // Add a check icon
        $this->info("Created tests for {$resource}.");
    }
   
}
