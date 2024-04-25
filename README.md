# Filament Tests

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewithdennis/filament-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-tests)
[![Total Downloads](https://img.shields.io/packagist/dt/codewithdennis/filament-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-tests)

A package that creates PEST tests specifically tailored for your Filament components.

## Early development

This package is still in early development. Some features may not be available yet or may not work as expected. If you encounter any issues, please create an [issue](https://github.com/CodeWithDennis/filament-tests/issues) on this repository.

> 🔴 This package is not production-ready yet, use it at your own risk. ⚠️

## Installation
You can install the package via composer:

```bash
composer require codewithdennis/filament-tests --dev
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-tests-config"
```

This is the contents of the published config file:

```php
return [
    /**
     * The directory where the tests will be generated in.
     */
    'directory_name' => env('FILAMENT_TESTS_DIRECTORY_NAME', 'tests/Feature'),

    /**
     * Whether to separate the tests into folders based on the resource name.
     */
    'separate_tests_into_folders' => env('FILAMENT_TESTS_SEPARATE_TESTS_INTO_FOLDERS', false),
];
```

## Requirements

This package requires [Filament v3](https://filamentphp.com/docs/3.x/panels/installation) or later to run.

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
php artisan make:filament-test BlogResource
```

You can also pass a comma-separated list of resource names to create tests for multiple resources at once:

```bash
php artisan make:filament-test "BlogResource, PostResource"
```

If you don't specify a resource name, you will be prompted to choose one or more resources to create tests for interactively.

```bash
php artisan make:filament-test
````
## Options

| Option             | Description                                                            |
|--------------------|------------------------------------------------------------------------|
| `--all` `-a`       | Create tests for all Filament resources                                |
| `--directory` `-d` | The output directory for the test                                      |
| `--except` `-e`    | Create tests for all Filament resources except the specified resources |
| `--force` `-f`     | Overwrite existing tests                                               |
| `--only` `-o`      | Create tests for the specified resources                               |

## Tests
Tests are generated on demand and are tailored to the component that you're generating tests for. For example, if the resource component doesn't have any sortable columns, then the tests for sorting 
won't be generated.

### Available Tests

<details>

<summary>List of available tests <i>(46)</i> ✔️</summary>

- it can render the registration page
- it can render the password reset page
- it can render the login page
- [it can render the create page](https://filamentphp.com/docs/3.x/panels/testing#routing--render)
-  [it has create form](https://filamentphp.com/docs/3.x/forms/testing#form-existence)
- [has a disabled field on create form](https://filamentphp.com/docs/3.x/forms/testing#disabled-fields)
- [it has a field on create form](https://filamentphp.com/docs/3.x/forms/testing#fields)
- [it has a hidden field on create form](https://filamentphp.com/docs/3.x/forms/testing#hidden-fields)
- [it can render the edit page](https://filamentphp.com/docs/3.x/panels/testing#routing--render)
- [it has a field on edit form](https://filamentphp.com/docs/3.x/forms/testing#fields)
- [it has a hidden field on edit form](https://filamentphp.com/docs/3.x/forms/testing#hidden-fields)
- [it has edit form](https://filamentphp.com/docs/3.x/forms/testing#form-existence)
- it has header actions on the index page
- it cannot render header actions on the index page
- it can render header actions on the index page
- [it can list records on the index page](https://filamentphp.com/docs/3.x/tables/testing#render)
- [it can list records on the index page with pagination](https://filamentphp.com/docs/3.x/tables/testing#render)
- [it can render the index page](https://filamentphp.com/docs/3.x/tables/testing#render)
- [it cannot display trashed records by default](https://filamentphp.com/docs/3.x/tables/testing#render)
- it has the correct table description
- it has the correct table heading
- [it can delete records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it can force delete records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it can soft delete records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it has table action](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it can replicate records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it can restore records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it has the correct URL for table action](https://filamentphp.com/docs/3.x/infolists/testing#url)
- [it has the correct URL and opens in a new tab for table action](https://filamentphp.com/docs/3.x/infolists/testing#url)
- it can bulk delete records
- it can bulk force delete records
- it can bulk delete records
- it has table bulk action
- it can bulk restore records
- it can bulk soft delete records
- [it cannot render column](https://filamentphp.com/docs/3.x/tables/testing#columns)
- [it has the correct descriptions above](https://filamentphp.com/docs/3.x/tables/testing#descriptions)
- [it has the correct descriptions below](https://filamentphp.com/docs/3.x/tables/testing#descriptions)
- [it has column](https://filamentphp.com/docs/3.x/tables/testing#existence)
- [it has extra attributes](https://filamentphp.com/docs/3.x/tables/testing#extra-attributes)
- [it can render column](https://filamentphp.com/docs/3.x/tables/testing#columns)
- [it can search column](https://filamentphp.com/docs/3.x/tables/testing#searching)
- [it can individually search by column](https://filamentphp.com/docs/3.x/tables/testing#searching)
- [it has the correct options](https://filamentphp.com/docs/3.x/tables/testing#select-columns)
- [it can sort column](https://filamentphp.com/docs/3.x/tables/testing#sorting)
- [it can reset table filters](https://filamentphp.com/docs/3.x/tables/testing#resetting-filters)
- [it can render the view page](https://filamentphp.com/docs/3.x/tables/testing#render)

</details>

### Unavailable Tests

<details>

<summary>List of unavailable tests <i>(66)</i> ✖️️</summary>

- it can register
- it can reset the password
- it can log in
- it can log out
- it can validate create form input
- [it can validate input on create form](https://filamentphp.com/docs/3.x/forms/testing#validation)
- it can render the custom page
- it can render actions on the custom page
- it can render the form on the custom page
- it can render the infolist on the custom page
- it can render the relation manager on the custom page
- it can render the table on the custom page
- it can render the widget on the custom page
- [has a disabled field on edit form](https://filamentphp.com/docs/3.x/forms/testing#disabled-fields)
- [it can validate input on edit form](https://filamentphp.com/docs/3.x/forms/testing#validation)
- [it can fill the form on the edit page](https://filamentphp.com/docs/3.x/forms/testing#filling-a-form)
- it can validate edit form input
- [it can add a table filter](https://filamentphp.com/docs/3.x/tables/testing#removing-filters)
- [it can remove a table filter](https://filamentphp.com/docs/3.x/tables/testing#removing-filters)
- [it can average values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can count values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can count the occurrence of icons in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can range date values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can range values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can sum values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can list records on the index page](https://filamentphp.com/docs/3.x/tables/testing#render)
- [it can list records on the index page with pagination](https://filamentphp.com/docs/3.x/tables/testing#render)
- [it can render the index page](https://filamentphp.com/docs/3.x/tables/testing#render)
- [it cannot display trashed records by default](https://filamentphp.com/docs/3.x/tables/testing#render)
- it has header actions on the index page
- it cannot render header actions on the index page
- it can render header actions on the index page
- it has the correct table description
- it has the correct table heading
- [it can delete records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it can force delete records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it can soft delete records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it has table action](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it can replicate records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it can restore records](https://filamentphp.com/docs/3.x/tables/testing#calling-actions)
- [it has the correct URL for table action](https://filamentphp.com/docs/3.x/infolists/testing#url)
- [it has the correct URL and opens in a new tab for table action](https://filamentphp.com/docs/3.x/infolists/testing#url)
- it can bulk delete records
- it can bulk force delete records
- it can bulk delete records
- it has table bulk action
- it can bulk restore records
- it can bulk soft delete records
- [it cannot render column](https://filamentphp.com/docs/3.x/tables/testing#columns)
- [it has state](https://filamentphp.com/docs/3.x/tables/testing#state)
- [it has the correct descriptions above](https://filamentphp.com/docs/3.x/tables/testing#descriptions)
- [it has the correct descriptions below](https://filamentphp.com/docs/3.x/tables/testing#descriptions)
- [it has column](https://filamentphp.com/docs/3.x/tables/testing#existence)
- [it has extra attributes](https://filamentphp.com/docs/3.x/tables/testing#extra-attributes)
- [it can render column](https://filamentphp.com/docs/3.x/tables/testing#columns)
- [it can search column](https://filamentphp.com/docs/3.x/tables/testing#searching)
- [it can individually search by column](https://filamentphp.com/docs/3.x/tables/testing#searching)
- [it has the correct options](https://filamentphp.com/docs/3.x/tables/testing#select-columns)
- [it can sort column](https://filamentphp.com/docs/3.x/tables/testing#sorting)
- [it can add a table filter](https://filamentphp.com/docs/3.x/tables/testing#removing-filters)
- [it can remove a table filter](https://filamentphp.com/docs/3.x/tables/testing#removing-filters)
- [it can reset table filters](https://filamentphp.com/docs/3.x/tables/testing#resetting-filters)
- [it can average values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can count values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can count the occurrence of icons in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can range date values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can range values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)
- [it can sum values in a column](https://filamentphp.com/docs/3.x/tables/testing#summaries)

</details>

### Publishing Stubs
You can customize the stubs by publishing them to your project:

```bash
php artisan vendor:publish --tag="filament-tests-stubs"
```

## Running the package tests

You can run your tests normally by running the following command:

```bash
vendor/bin/pest
```

You can choose to only run the tests for this package by running the following command:

```bash
vendor/bin/pest --group=filament-tests
```

You can also run all your tests except the ones for this package by running the following command:

```bash
vendor/bin/pest --exclude-group=filament-tests
```

### Additional grouping options
| Name                 | Includes                                                |
|----------------------|---------------------------------------------------------|
| `filters`            | Runs the tests for the filters                          |
| `page`               | Runs the tests for the pages                            |
| `render`             | Runs the tests that check if the page renders correctly |
| `table`              | Runs the tests for the table                            |
| `table-actions`      | Runs the tests for table actions                        |
| `table-bulk-actions` | Runs the tests for table bulk actions                   |
> You can add any of those above groups to either `--exclude-group` or `--group` to include or exclude them from the test run. You can comma-separate multiple groups.

## Credits

- [CodeWithDennis](https://github.com/CodeWithDennis)
- [Dissto](https://github.com/dissto)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
