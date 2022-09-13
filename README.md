## Sitemap wrapper for Laravel

### Laravel wrapper for [Sitemap package](https://github.com/popsycode/test-site-map)

## Installation

Require this package in your composer.json and update composer.

    composer require popsy/laravel-site-map

Add provider to config/app.php

```php
Popsy\LaravelSiteMap\SitemapServiceProvider::class,
```

You can add alias for Sitemap Facade to config/app.php

```php
'Sitemap' => Popsy\LaravelSiteMap\Facade\Sitemap::class,
```

You can publish configuration file

```
php artisan vendor:publish --provider="Popsy\LaravelSiteMap\SitemapServiceProvider"
```


## Usage

Use this data format:

```php
$data = [
    [
        'loc' =>"https://site.ru/",
        'lastmod' =>"2020-12-14",
        'priority' =>1,
        'changefreq' =>"hourly"
    ],
    [
        'loc' =>"https://site.ru/news",
        'lastmod' =>"2020-12-10",
        'priority' =>0.5,
        'changefreq' =>"daily"
    ],
    // .....
];
```
For example

```php
use Popsy\LaravelSiteMap\Facade\Sitemap;

Sitemap::setType('json')
    ->setData($data)
    ->setFilePath(public_path('sitemap.json'))
    ->generate();
```

or

```php
public function handle(IGenerator $generator)
{
    $data = [/*....*/];
    $generator
        ->setData($data)
        ->setFilePath(public_path('sitemap.xml'))
        ->generate();
}
```
