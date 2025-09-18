# Filament Tests

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewithdennis/filament-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-tests)
[![Total Downloads](https://img.shields.io/packagist/dt/codewithdennis/filament-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-tests)

A package that creates PEST tests specifically tailored for your Filament components.

> [!CAUTION]  
> This package is not ready yet, use it at your own risk. ⚠️

## Installation

```bash
composer require codewithdennis/filament-tests --dev
```

## Usage

Run the command to generate tests for your Filament resources:

```bash
php artisan make:filament-test
```

### Command Options

The `make:filament-test` command supports the following options:

- `--skip-pint`: Skip running Laravel Pint on generated test files
- `--force`: Overwrite existing test files without confirmation

## Available Tests

This package generates comprehensive PEST tests for your Filament resources. Here's a complete list of currently working tests:

### Form Record Tests
- **CanCreateRecordTest** - Tests that a record can be created
- **CanValidateCreateFormTest** - Tests that the create form validates input correctly
  - [x] Max
  - [x] Min
  - [x] Required

### Page Rendering Tests
- **CanRenderCreatePageTest** - Tests that the create page renders correctly
- **CanRenderEditPageTest** - Tests that the edit page renders correctly  
- **CanRenderIndexPageTest** - Tests that the index page renders correctly
- **CanRenderViewPageTest** - Tests that the view page renders correctly

### Page Functionality Tests
- **HasHeaderActionTest** - Tests that header actions exist
- **ShowsHeaderActionTest** - Tests that a header action is visible
- **HidesHeaderActionTest** - Tests that a header action is hidden

### Table Column Tests
- **HasColumnTest** - Tests that the resource has table columns defined
- **CanRenderColumnTest** - Tests that default visible columns render correctly
- **CanNotRenderColumnTest** - Tests that default hidden columns don't render
- **ShowsColumnTest** - Tests that explicitly visible columns are shown
- **HidesColumnTest** - Tests that explicitly hidden columns are hidden
- **CanNotDisplayTrashedRecordsByDefault** - Tests that trashed records are not displayed by default if soft deletes are enabled
- **ColumnHasDescriptionBelowTest** - Tests that columns with descriptions display them below
- **ColumnHasDescriptionAboveTest** - Tests that columns with descriptions display them above
- **SelectColumnHasOptionsTest** - Tests that select columns have the correct options
- **ColumnHasExtraAttributesTest** - Tests that columns with extra attributes render them correctly

### Table Functionality Tests
- **CanSearchColumnTest** - Tests that searchable columns work correctly
- **CanSearchColumnIndividuallyTest** - Tests that individual column search works correctly
- **CanSortColumnTest** - Tests that sortable columns work correctly
- **CanPaginateRecordsTest** - Tests that pagination works correctly

### Table Filter Tests
- **HasFilterTest** - Tests that a filter exists

### Bulk Action Tests
- **CanBulkDeleteRecordsTest** - Tests that bulk delete action works correctly

### Setup Tests
- **BeforeEach** - Sets up common test configuration and data

All tests are automatically generated based on your Filament resource configuration and will only run when the relevant features are present in your resource (e.g., search tests only run if you have searchable columns).

## Known Issues
- Validation of RichEditor fields is not supported, this is due to the complexity of handling rich text content in tests.

## Credits

- [CodeWithDennis](https://github.com/CodeWithDennis)
- [Dissto](https://github.com/dissto)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
