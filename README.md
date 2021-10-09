# sitemap
Sitemap package for Jasmine

## Installation
`composer require jasminecms/sitemap`

Add a route for the sitemap.xml and in your action return
`\JasmineSitemap::generate()`

In your `AppServiceProvider`
Register your single pages/routes
`\JasmineSitemap::registerRoute($url|$route_name, $params, $cb)`

Register your models
`\JasmineSitemap::registerModel($query)`
Your model should implement `Spatie\Sitemap\Contracts\Sitemapable`

