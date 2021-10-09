<?php

namespace Jasmine\Sitemap;

use Illuminate\Support\ServiceProvider;

class JasmineSitemapServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('jasmine-sitemap', fn() => new JasmineSitemap());
    }

    public function boot()
    {
    }
}
