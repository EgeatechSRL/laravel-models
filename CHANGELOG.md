# Changelog

All notable changes to `LaravelModels` will be documented in this file.

## Version 3.0.2

### Fixed

- `SupportsQueryBuilderInterface` required the implementation of the method removed in `v3.0.1`

## Version 3.0.1

### Fixed

- Removing method from `BaseRepository` as it was dropped from Spatie's library

## Version 3.0.0

### Removed

- Support for PHP 7.4

### Updated

- [Laravel Requests](https://packagist.org/packages/egeatech/laravel-requests) version to 2.x
- [Laravel Query Builder](https://packagist.org/packages/spatie/laravel-query-builder) version to 5.x

## Version 2.3.3

### Added

- Support for Laravel 9

### Updated

- Composer dependencies

## Version 2.3.2

### Fixed

- PHP version specified in `composer.json` file

## Version 2.3.1

### Fixed

- Model identifier custom key definition is used on value retrieval and data persistence to update another field of a
  model

## Version 2.3.0

### Added

- Ability to compare define a custom key to handle model identifier automatic casting

## Version 2.2.0

### Added

- Ability to compare model identifiers with values possibly `null`

## Version 2.1.0

### Added

- Ability to automatically cast FK attributes of Model classes to ModelIdentifier instances

## Version 2.0.2

### Fixed

- `BaseRepository::getRecordsViaModelQuery` method
- `ItemsPerPageResolver::getPageSize` when forcing user-defined page size

## Version 2.0.1

### Fixed

- `BaseRepository::__construct`, better DI handling

## Version 2.0.0

### Fixed

- `BaseRepository::findManyByIds` method, which wrongly thrown an exception
- Pagination parameters for `BaseRepository::index` method, which were not considered when querying a Model

### Updated

- `BaseRepository::all` is now `BaseRepository::allWhere`
- `BaseRepository::findMany` is now `BaseRepository::findManyByIds`

### Added

- Page dimension resolver when performing paginated API calls

## Version 1.0.3

### Fixed

- Methods in `BaseRepository` shared the same model instance when executing queries (for example, invoking
  multiple `store` calls caused data overwriting)

## Version 1.0.2

### Fixed

- `findRecordViaAdvancedQueryBuilder` return value in `BaseRepository` class

## Version 1.0.1

### Added

- `Queryable` trait

### Fixed

- `SupportsQueryBuilderInterface` namespace
- Import in `BaseRepository` for `Collection` class

## Version 1.0.0

### Added

- Model repositories, identifiers and general scaffolding
