# Changelog

All notable changes to `LaravelModels` will be documented in this file.

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
- Methods in `BaseRepository` shared the same model instance when executing queries (for example, invoking multiple `store` calls caused data overwriting) 

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
