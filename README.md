# elastic-laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

**Note:** Replace ```Mina Abadir``` ```mabadir``` ```mina.io``` ```mina@abadir.email``` ```mabadir``` ```elastic-laravel``` ```Elastic Search Indexer for Laravel 5``` with their correct values in [README.md](README.md), [CHANGELOG.md](CHANGELOG.md), [CONTRIBUTING.md](CONTRIBUTING.md), [LICENSE.md](LICENSE.md) and [composer.json](composer.json) files, then delete this line. You can run `$ php prefill.php` in the command line to make all replacements at once. Delete the file prefill.php as well.

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practises by being named the following.

```
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require mabadir/elastic-laravel
```

## Usage
Add the ElasticEloquent trait to your Eloquent model to have it indexed.

``` php
namespace App;
 
use MAbadir\ElasticLaravel\ElasticEloquent;
 
class User extends Authenticatable
{
    use ElasticEloquent;
 
}
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email mina@abadir.email instead of using the issue tracker.

## Credits

- [Mina Abadir][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mabadir/elastic-laravel.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/mabadir/elastic-laravel/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/mabadir/elastic-laravel.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/mabadir/elastic-laravel.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mabadir/elastic-laravel.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/mabadir/elastic-laravel
[link-travis]: https://travis-ci.org/mabadir/elastic-laravel
[link-scrutinizer]: https://scrutinizer-ci.com/g/mabadir/elastic-laravel/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/mabadir/elastic-laravel
[link-downloads]: https://packagist.org/packages/mabadir/elastic-laravel
[link-author]: https://github.com/mabadir
[link-contributors]: ../../contributors
