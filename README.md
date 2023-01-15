[![Latest Version on Packagist](https://img.shields.io/packagist/v/samirsabiee/laravel-hotfix.svg?style=flat-square)](https://packagist.org/packages/samirsabiee/laravel-hotfix)
[![Tests](https://github.com/samirsabiee/laravel-hotfix/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/samirsabiee/laravel-hotfix/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/samirsabiee/laravel-hotfix.svg?style=flat-square)](https://packagist.org/packages/samirsabiee/laravel-hotfix)
<!--delete-->
---
Hotfix laravel package with DB Transaction control


## Installation

You can install the package via composer:

```bash
composer require samirsabiee/laravel-hotfix
```

## Usage
* Commands
  * ```bash
    php artisan hotfix {{NUMBER}}
    ```
    Above command execute {{NUMBER}} last **not executed** hotfixes created in path config under app/Hotfixes directory
  * ```bash
    php artisan hotfix all
    ```
    Above command execute all **not executed** hotfixes created in path config under app/Hotfixes directory



```php
$skeleton = new SamirSabiee\Hotfix();
echo $skeleton->echoPhrase('Hello, SamirSabiee!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Samir Sabiee](https://github.com/samirsabiee)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
