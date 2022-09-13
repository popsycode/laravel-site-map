<?php

namespace Popsy\LaravelSiteMap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Popsy\SiteMap\GeneratorFactory;
use Popsy\SiteMap\IGenerator;
use Popsy\SiteMap\IGeneratorFactory;

class SitemapServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(IGeneratorFactory::class, GeneratorFactory::class);

        $configPath = __DIR__ . '/../config/sitemap.php';
        $this->mergeConfigFrom($configPath, 'sitemap');

        $this->app->bind('sitemap', function (Application $app){
            return (new GeneratorFactory())
                ->createGenerator($app['config']->get('sitemap.default'));
        });

        $this->app->alias('sitemap', IGenerator::class);

        $this->app->bind('sitemap.wrapper', function (Application $app) {
            return new Sitemap($app['sitemap'], $app['config']);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sitemap.php' => config_path('sitemap.php')
        ], 'sitemap-config');
    }

    public function provides(): array
    {
        return ['sitemap', 'sitemap.wrapper'];
    }
}
