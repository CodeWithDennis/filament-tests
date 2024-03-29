# Filament Resource Tests

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewithdennis/filament-resource-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-resource-tests)
[![Total Downloads](https://img.shields.io/packagist/dt/codewithdennis/filament-resource-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-resource-tests)

A package that creates PEST tests specifically tailored for your Filament components.

## This package is still in development and not ready for use.
### Please do not use it in production.

## Installation
You can install the package via composer:

```bash
composer require codewithdennis/filament-resource-tests
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
## Usage

You can create a new test for a resource by running the following command:

```bash
php artisan make:filament-resource-test BlogResource
```

If you don't specify a resource name, you will be prompted to choose one or more resources to create tests for.

```bash
php artisan make:filament-resource-test
````

### Generated Tests
Tests will only be generated if they can actually be used. For example, if the resource doesn't have any sortable columns, then the tests for sorting won't be generated.

In these examples, we'll assume that we have a `Blog` model and a `BlogResource` resource that have the following columns:
- id
- name

**To ensure a table component renders**

```php
it('can render page', function () {
    livewire(ListBlogs::class)->assertSuccessful();
});
```

**To ensure that a certain columns are rendered**

```php
it('can render column', function (string $column) {
    Blog::factory()->count(3)->create();

    livewire(ListBlogs::class)->assertCanRenderTableColumn($column);
})->with(['id', 'name']);
```

**To ensure that columns exists**

```php
it('has column', function (string $column) {
    livewire(ListBlogs::class)
        ->assertTableColumnExists($column);
})->with(['id', 'name']);
```

**To ensure that a certain columns are sortable**

```php
it('can sort column', function (string $column) {
    $records = Blog::factory()->count(3)->create();

    livewire(ListBlogs::class)
        ->sortTable($column)
        ->assertCanSeeTableRecords($records->sortBy($column), inOrder: true)
        ->sortTable($column, 'desc')
        ->assertCanSeeTableRecords($records->sortByDesc($column), inOrder: true);
})->with(['id', 'name']);
```

**To ensure that a certain columns are searchable**

```php
it('can search column', function (string $column) {
    $records = Blog::factory()->count(3)->create();

    $search = $records->first()->{$column};

    livewire(ListBlogs::class)
        ->searchTable($search)
        ->assertCanSeeTableRecords($records->where($column, $search))
        ->assertCanNotSeeTableRecords($records->where($column, '!=', $search));
})->with(['id', 'name']);
```

**To ensure that a certain columns are individually searchable**

```php
it('can individually search by column', function (string $column) {
    $records = Blog::factory()->count(3)->create();

    $search = $records->first()->{$column};

    livewire(ListBlogs::class)
        ->searchTableColumns([$column => $search])
        ->assertCanSeeTableRecords($records->where($column, $search))
        ->assertCanNotSeeTableRecords($records->where($column, '!=', $search));
})->with(['id', 'name']);
```

**To ensure that a certain records are not displayed by default**

```php
it('cannot display trashed records by default', function () {
    $records = Blog::factory()->count(3)->create();

    $trashedRecords = Blog::factory()->trashed()->count(6)->create();

    livewire(ListBlogs::class)
        ->assertCanSeeTableRecords($records)
        ->assertCanNotSeeTableRecords($trashedRecords)
        ->assertCountTableRecords(3);
});
```

**To ensure that the delete action works**

```php
it('can delete records', function () {
    $record = Blog::factory()->create();

    livewire(ListBlogs::class)
        ->callTableAction(DeleteAction::class, $record);

    $this->assertModelMissing($record);
});
```

**To ensure that the soft delete action works**

```php
it('can soft delete records', function () {
    $record = Blog::factory()->create();

    livewire(ListBlogs::class)
        ->callTableAction(DeleteAction::class, $record);

    $this->assertSoftDeleted($record);
});
```

**To ensure that the delete bulk action works**

```php
it('can bulk delete records', function () {
    $records = Blog::factory()->count(3)->create();

    livewire(ListBlogs::class)
        ->callTableBulkAction(DeleteBulkAction::class, $records);

    foreach ($records as $record) {
        $this->assertModelMissing($record);
    }

    expect(Blog::find($records->pluck('id')))->toBeEmpty();
});
```

**To ensure that the soft delete bulk action works**

```php
it('can bulk soft delete records', function () {
    $records = Blog::factory()->count(3)->create();

    livewire(ListBlogs::class)
        ->callTableBulkAction(DeleteBulkAction::class, $records);

    foreach ($records as $record) {
        $this->assertSoftDeleted($record);
    }

    expect(Blog::find($records->pluck('id')))->toBeEmpty();
});
```

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