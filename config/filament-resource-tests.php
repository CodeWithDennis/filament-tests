<?php

return [
    /**
     * The directory where the tests will be generated in.
     */
    'directory_name' => env('FILAMENT_RESOURCE_TESTS_DIRECTORY_NAME', 'tests/Feature'),

    /**
     * Whether to separate the tests into folders based on the resource name.
     */
    'separate_tests_into_folders' => env('FILAMENT_RESOURCE_TESTS_SEPARATE_TESTS_INTO_FOLDERS', false),

    /**
     * Ignore the following columns when generating the tests.
     */
    'ignored_columns' => [
//        'id',
//        'created_at',
//        'updated_at',
    ],
];
