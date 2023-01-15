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
    php artisan hotfix:make <<NAME>>
    ```
    Above command create stub hotfix file app/Hotfixes/**config.path**

  * ```bash
    php artisan hotfix <<NUMBER>>
    ```
    Above command execute **NUMBER** last **not executed** hotfixes created in path config under app/Hotfixes directory

  * ```bash
    php artisan hotfix all
    ```
    Above command execute all **not executed** hotfixes created in path config under app/Hotfixes directory
  * ```bash
    php artisan hotfix:run <<NAME>>
    ```
    Above command run single hotfix By entering hotfix name (you can enter part of name and select one of founded hotfixes)

  * ```bash
    php artisan hotfix:ls 
    ```
    Above command list 10 last hotfixes with error and status column

  * ```bash
    php artisan hotfix:ls <<NUMBER>>
    ```
    Above command list **NUMBER** last hotfixes with error and status column

  * ```bash
    php artisan hotfix:ls <<NUMBER>> --error
    ```
    Above command list **NUMBER** last hotfixes executed with error

  * ```bash
    php artisan hotfix:logs <<ID>>
    ```
    Above command show long log of hotfix by id shown in ls command

  * ```bash
    php artisan hotfix:retry <<ID>>
    ```
    Above command retry hotfix that executed with error by ID shown in ls command

  * ```bash
    php artisan hotfix:retry all
    ```
    Above command retry all hotfixes executed with error

  * ```bash
    php artisan hotfix:status <<NAME>>
    ```
    Above command show status single hotfix By entering hotfix name (you can enter part of name and select one of founded hotfixes)

## Credits

- [Samir Sabiee](https://github.com/samirsabiee)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
