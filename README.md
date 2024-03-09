# Filament Resource Tests

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewithdennis/filament-resource-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-resource-tests)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/codewithdennis/filament-resource-tests/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/codewithdennis/filament-resource-tests/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/codewithdennis/filament-resource-tests/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/codewithdennis/filament-resource-tests/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/codewithdennis/filament-resource-tests.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-resource-tests)

A package that creates PEST tests specifically tailored for your filament resources.

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
    //
];
```

## Usage

```php
<?php

//
```
## Testing

```bash
composer test
```

## Credits

- [CodeWithDennis](https://github.com/CodeWithDennis)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
