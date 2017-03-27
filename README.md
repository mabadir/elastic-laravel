# elastic-laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Elastic Search Indexer for Laravel 5.

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
Add the `ElasticLaravelServiceProvider` to your `config/app.php`.
``` php
'providers' => [
//Other providers
    MAbadir\ElasticLaravel\ElasticLaravelServiceProvider::class,
],
```

Publish the `elastic.php` to your configuration.
``` bash
$ php artisan vendor:publish
```
Add the ElasticEloquent trait to your Eloquent model to have it indexed.

``` php
namespace App;
 
use MAbadir\ElasticLaravel\ElasticEloquent;
 
class User extends Authenticatable
{
    use ElasticEloquent;
 
}
```

For searching the index, you can run search with different approaches. The first step is to add the Facade to your `config/app.php`:

``` php
'aliases' => [
    //Other Facades
   'ElasticSearcher' => MAbadir\ElasticLaravel\ElasticSearcher::class,
],
```

1. Simple term search:

```php
ElasticSearcher::search('simple term');
```

2. Simple term search on specific model type:
```php
$user = App\User::first();
ElasticSearcher::search('Simple Term', $user);
```
This will search the Elastic Search index for the simple term with `type=users`.

3. Search index on specific parameter:
```php
ElasticSearcher::search(['name' => 'First Name']);
```
This will search the complete Search Index for the parameter name with value `First Name`

4. Search index on specific parameter and specific model type:
```php
$user = App\User::first();
ElasticSearcher::search(['name' => 'First Name'], $user);
```
This will search the Search Index for the parameter name with value `First Name` on `type=users`. 

5. Advanced Search:
```php
$params = [
            'body' => [
                'query' => [
                    'match' => [
                        '_all' => 'Simple Term'
                    ]
                ]
            ]
        ];
ElasticSearcher::advanced($params);
```
This exposes the complete Elastic Search powerful query DSL interface, this will accept any acceptable Elastic Search DSL query.

6. Advanced Search:
```php
$user = User::first();
$params = [
            'body' => [
                'query' => [
                    'match' => [
                        '_all' => 'Simple Term'
                    ]
                ]
            ]
        ];
ElasticSearcher::advanced($params, $user);
```
This will search the index using the advanced query for `type=users`.

For the different functions, the class name can be used instead of the object itself, the object or the class should be extending Eloquent Model class `\Illuminate\Database\Eloquent\Model`. For example:
```php
ElasticSearcher::search(['name' => 'First Name'], User::class);
```

#### ElasticSearch Indexing Console Command
By default the package provides a default index initialization command:
```
$ php artisan es:init
```
The default command will initialize the index with very basic settings. If it is required to initialize the index with more advanced settings and custom mappings:
Create a new Console Command in your application:
```
$ php artisan make:command IndexIntializationCommand
```
Import the `IndexInitializationTrait` class, and overload the `$params` attribute:

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use MAbadir\ElasticLaravel\Console\IndexInitializationTrait;

class IndexIntializationCommand extends Command
{
    use IndexInitializationTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize ElasticSearch Index';
    
    /**
     * Parameters array
     * 
     * @var array
     */
    protected $params = [
        //Custom Settings
    ];
}

```
For more details on the configuration parameters, check the official [ElasticSearch documentation][link-esdocs].


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
[link-esdocs]: https://www.elastic.co/guide/en/elasticsearch/client/php-api/5.0/_index_management_operations.html
