# Filament Tests

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewithdennis/filament-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-tests)
[![Total Downloads](https://img.shields.io/packagist/dt/codewithdennis/filament-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-tests)

A package that creates PEST tests specifically tailored for your Filament components.

## Installation

```bash
composer require codewithdennis/filament-tests --dev
```

## Usage

Run the command to generate tests for your Filament resources:

```bash
php artisan make:filament-test
```

### Command Flags

The `make:filament-test` command supports the following options:

- `--skip-pint`: Skip running Laravel Pint on generated test files
- `--force`: Overwrite existing test files without confirmation

## Credits

- [CodeWithDennis](https://github.com/CodeWithDennis)
- [Dissto](https://github.com/dissto)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
