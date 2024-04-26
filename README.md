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

> 💡 The following tests are generated (if applicable) and are ready to be run.

<details>

<summary>List of available tests <i>(46)</i> ✔️</summary>

<details>

<summary>it can render the registration page</summary>

> No details yet!

</details>

<details>

<summary>it can render the registration page</summary>

> No details yet!

</details>
<details>

<summary>it can render the password reset page</summary>

> No details yet!

</details>
<details>

<summary>it can render the login page</summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/panels/testing#routing--render">it can render the create page</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#form-existence">it has create form</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#disabled-fields">has a disabled field on create form</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#fields">it has a field on create form</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#hidden-fields">it has a hidden field on create form</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/panels/testing#routing--render">it can render the edit page</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#fields">it has a field on edit form</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#hidden-fields">it has a hidden field on edit form</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#form-existence">it has edit form</a></summary>

> No details yet!

</details>
<details>

<summary>it has header actions on the index page</summary>

> No details yet!

</details>
<details>

<summary>it cannot render header actions on the index page</summary>

> No details yet!

</details>
<details>

<summary>it can render header actions on the index page</summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#render">it can list records on the index page</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#render">it can list records on the index page with pagination</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#render">it can render the index page</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#render">it cannot display trashed records by default</a></summary>

> No details yet!

</details>
<details>

<summary>it has the correct table description</summary>

> No details yet!

</details>
<details>

<summary>it has the correct table heading</summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can delete records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can force delete records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can soft delete records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it has table action</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can replicate records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can restore records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/infolists/testing#url">it has the correct URL for table action</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/infolists/testing#url">it has the correct URL and opens in a new tab for table action</a></summary>

> No details yet!

</details>
<details>

<summary>it can bulk delete records</summary>

> No details yet!

</details>
<details>

<summary>it can bulk force delete records</summary>

> No details yet!

</details>
<details>

<summary>it can bulk delete records</summary>

> No details yet!

</details>
<details>

<summary>it has table bulk action</summary>

> No details yet!

</details>
<details>

<summary>it can bulk restore records</summary>

> No details yet!

</details>
<details>

<summary>it can bulk soft delete records</summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#columns">it cannot render column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#descriptions">it has the correct descriptions above</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#descriptions">it has the correct descriptions below</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#existence">it has column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#extra-attributes">it has extra attributes</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#columns">it can render column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#searching">it can search column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#searching">it can individually search by column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#select-columns">it has the correct options</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#sorting">it can sort column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#resetting-filters">it can reset table filters</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#render">it can render the view page</a></summary>

> No details yet!

</details>

</details>

### Unavailable Tests
> ⚠️ The following tests are not yet generated, instead they'll be added as `->todo()` and you can fill them in manually. Or maybe consider [contributing](#contributing) to this package instead.

<details>

<summary>List of unavailable tests <i>(66)</i> ✖️️</summary>

<details>

<summary>it can register</summary>

> No details yet!

</details>

<details>

<summary>it can reset the password</summary>

> No details yet!

</details>

<details>

<summary>it can log in</summary>

> No details yet!

</details>
<details>

<summary>it can log out</summary>

> No details yet!

</details>
<details>

<summary>it can validate create form input</summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#validation">it can validate input on create form</a></summary>

> No details yet!

</details>
<details>

<summary>it can render the custom page</summary>

> No details yet!

</details>
<details>

<summary>it can render actions on the custom page</summary>

> No details yet!

</details>
<details>

<summary>it can render the form on the custom page</summary>

> No details yet!

</details>
<details>

<summary>it can render the infolist on the custom page</summary>

> No details yet!

</details>
<details>

<summary>it can render the relation manager on the custom page</summary>

> No details yet!

</details>
<details>

<summary>it can render the table on the custom page</summary>

> No details yet!

</details>
<details>

<summary>it can render the widget on the custom page</summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#disabled-fields">has a disabled field on edit form</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#validation">it can validate input on edit form</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/forms/testing#filling-a-form">it can fill the form on the edit page</a></summary>

> No details yet!

</details>
<details>

<summary>it can validate edit form input</summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#removing-filters">it can add a table filter</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#removing-filters">it can remove a table filter</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can average values in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can count values in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can count the occurrence of icons in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can range date values in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can range values in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can sum values in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#render">it can list records on the index page</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#render">it can list records on the index page with pagination</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#render">it can render the index page</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#render">it cannot display trashed records by default</a></summary>

> No details yet!

</details>
<details>

<summary>it has header actions on the index page</summary>

> No details yet!

</details>
<details>

<summary>it cannot render header actions on the index page</summary>

> No details yet!

</details>
<details>

<summary>it can render header actions on the index page</summary>

> No details yet!

</details>
<details>

<summary>it has the correct table description</summary>

> No details yet!

</details>
<details>

<summary>it has the correct table heading</summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can delete records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can force delete records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can soft delete records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it has table action</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can replicate records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#calling-actions">it can restore records</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/infolists/testing#url">it has the correct URL for table action</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/infolists/testing#url">it has the correct URL and opens in a new tab for table action</a></summary>

> No details yet!

</details>
<details>

<summary>it can bulk delete records</summary>

> No details yet!

</details>
<details>

<summary>it can bulk force delete records</summary>

> No details yet!

</details>
<details>

<summary>it can bulk delete records</summary>

> No details yet!

</details>
<details>

<summary>it has table bulk action</summary>

> No details yet!

</details>
<details>

<summary>it can bulk restore records</summary>

> No details yet!

</details>
<details>

<summary>it can bulk soft delete records</summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#columns">it cannot render column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#state">it has state</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#descriptions">it has the correct descriptions above</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#descriptions">it has the correct descriptions below</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#existence">it has column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#extra-attributes">it has extra attributes</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#columns">it can render column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#searching">it can search column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#searching">it can individually search by column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#select-columns">it has the correct options</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#sorting">it can sort column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#removing-filters">it can add a table filter</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#removing-filters">it can remove a table filter</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#resetting-filters">it can reset table filters</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can average values in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can count values in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can count the occurrence of icons in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can range date values in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can range values in a column</a></summary>

> No details yet!

</details>
<details>

<summary><a href="https://filamentphp.com/docs/3.x/tables/testing#summaries">it can sum values in a column</a></summary>

> No details yet!

</details>

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
