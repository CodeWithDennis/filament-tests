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
     * FQCN to the default User model.
     */
    'user_model' => env('FILAMENT_RESOURCE_TESTS_USER_MODEL', App\Models\User::class),
];
