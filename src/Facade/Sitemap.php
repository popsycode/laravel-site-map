<?php

namespace Popsy\LaravelSiteMap\Facade;

use Illuminate\Support\Facades\Facade;

class Sitemap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sitemap.wrapper';
    }

}
