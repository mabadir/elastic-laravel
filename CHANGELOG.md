# Changelog

All Notable changes to `elastic-laravel` will be documented in this file.

## [Unreleased]
- Nothing


## [1.1.0] - 2017-03-21

- Using standard Laravel functionality for Default Indexing values
- Added search functionality

### Added
- ElasticSearcher class to perform all searching functionality

### Deprecated
- Nothing

### Fixed
- Using `getKey()` and `getTable()` for default indexing.

### Removed
- Nothing

### Security
- Nothing

## [1.0.0] - 2017-03-21

- Initial Release

### Added
- ElasticClient a simple client to interface ElasticSearch PHP
- ElasticEloquent trait for Eloquent models
- ModelObserver to handle model events
- IndexModel Job to take care of Elastic Search indexing

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing
