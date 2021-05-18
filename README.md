# Laravel Exceptions

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

A package to help handling Model CRUD operations.

## Installation

This package supports Laravel 7 and 8 but requires **at least** PHP 7.4. 

Via Composer

``` bash
$ composer require egeatech/laravel-models
```

## Usage

This package exposes an interface to manipulate database data, by using an implementation of the
repository data pattern.

We provide both an interface and an abstract implementation to be extended.
To develop APIs, the abstract class references [Spatie Query Builder library](https://spatie.be/docs/laravel-query-builder/v3/introduction)
for the `find` and `index` methods (for more details take a look at the source code).

To identify primary keys of eloquent Model classes, we also developed an `IdentifierInterface` (with an abstract class
to be extended for specific needs) which is used by the `BaseRepository` when dealing with specific entity operations,
such as update, delete or find.

At the moment we only support `int` or `string` PKs, composite keys support will be added in the future.

## Change log

Please see the [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Egea Tecnologie Informatiche][link-author]
- [Marco Guidolin](mailto:m.guidolin@egeatech.com)

## License

The software is licensed under MIT. Please see the [LICENSE](LICENSE.md) file for more information.

[ico-version]: https://img.shields.io/packagist/v/egeatech/laravel-models.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/egeatech/laravel-models.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/egeatech/laravel-models
[link-downloads]: https://packagist.org/packages/egeatech/laravel-models
[link-travis]: https://travis-ci.org/egeatech/laravel-models
[link-author]: https://egeatech.com
