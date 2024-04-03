# Filament Resource Tests

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewithdennis/filament-resource-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-resource-tests)
[![Total Downloads](https://img.shields.io/packagist/dt/codewithdennis/filament-resource-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-resource-tests)

A package that creates PEST tests specifically tailored for your Filament components.

## Early development

This package is still in early development. Some features may not be available yet or may not work as expected. If you encounter any issues, please create an [issue](https://github.com/CodeWithDennis/filament-resource-tests/issues) on this repository.

> 🔴 This package is not production-ready yet, use it at your own risk. ⚠️

## Installation
You can install the package via composer:

```bash
composer require codewithdennis/filament-resource-tests --dev
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-resource-tests-config"
```

This is the contents of the published config file:

```php
return [
    /**
     * The directory where the tests will be generated in.
     */
    'directory_name' => env('FILAMENT_RESOURCE_TESTS_DIRECTORY_NAME', 'tests/Feature'),

    /**
     * Whether to separate the tests into folders based on the resource name.
     */
    'separate_tests_into_folders' => env('FILAMENT_RESOURCE_TESTS_SEPARATE_TESTS_INTO_FOLDERS', false),
];
```

## Requirements

This package generates [PestPHP](https://pestphp.com/docs/installation) tests, make sure you have it installed in your project. You can install it by running the following command:

```bash
composer require pestphp/pest --dev --with-all-dependencies
```

Make sure you have the following packages installed as well:

```bash
composer require pestphp/pest-plugin-livewire --dev
```
```bash
composer require pestphp/pest-plugin-laravel --dev
```

## Usage

You can create a new test for a resource by running the following command:
> The following name formats are supported: `blog`, `Blog`, `BlogResource`

```bash
php artisan make:filament-resource-test BlogResource
```

If you don't specify a resource name, you will be prompted to choose one or more resources to create tests for interactively.

```bash
php artisan make:filament-resource-test
````
## Options

| Option       | Description |
|--------------|-------------|
| `--all` `-a` | Create tests for all Filament resources |
| `--force` `-f` | Overwrite existing tests |

## Tests
Tests are generated on demand and are tailored to the component that you're generating tests for. For example, if the resource component doesn't have any sortable columns, then the tests for sorting 
won't be generated.

**Resources**
  - [x] [It can render page](https://filamentphp.com/docs/3.x/tables/testing#render)
  - [x] [It can render create page](https://filamentphp.com/docs/3.x/panels/testing#create)
  - [x] [It can render edit page](https://filamentphp.com/docs/3.x/panels/testing#edit)
  - [x] [It can not render page](https://filamentphp.com/docs/3.x/tables/testing#render)
  - [x] [It can sort column](https://filamentphp.com/docs/3.x/tables/testing#sorting)
  - [x] [It can render column](https://filamentphp.com/docs/3.x/tables/testing#columns)
  - [x] [It can search column](https://filamentphp.com/docs/3.x/tables/testing#searching)
  - [x] [It has column](https://filamentphp.com/docs/3.x/tables/testing#existence)
  - [x] [It has the correct descriptions](https://filamentphp.com/docs/3.x/tables/testing#descriptions)
  - [x] It can delete records
  - [x] It can soft delete records
  - [x] It can bulk delete records
  - [x] It can bulk soft delete records
  - [x] It can restore records
  - [x] It can bulk restore records
  - [x] It can replicate records
  - [x] It can force delete records
  - [x] It can bulk force delete records
  - [ ] It can filter table records
  - [ ] It can reset table filters
  - [ ] It can remove table filters

## Running the package tests

You can run your tests normally by running the following command:

```bash
vendor/bin/pest
```

You can choose to only run the tests for this package by running the following command:

```bash
vendor/bin/pest --group=filament-resource-tests
```

You can also run all your tests except the ones for this package by running the following command:

```bash
vendor/bin/pest --exclude-group=filament-resource-tests
```

## Credits

- [CodeWithDennis](https://github.com/CodeWithDennis)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
