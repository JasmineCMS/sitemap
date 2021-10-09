<?php

namespace Jasmine\Sitemap;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class JasmineSitemap
{
    protected array $models = [];

    protected array $urls = [];

    public function registerModel(Builder $query)
    {
        $this->models[$query->getModel()::class] = $query;
    }

    public function registerRoute($url, array $params = [], ?\Closure $cb = null)
    {
        $this->urls[$url] = [$params, $cb];
    }

    public function generate()
    {
        $sm = Sitemap::create();

        foreach ($this->urls as $url => $item) {
            $url = Url::create(str_starts_with($url, 'http') ? $url
                : route($url, $item[0]));
            $item[1] && $item[1]($url);
            $sm->add($url);
        }

        foreach ($this->models as $class => $query) {
            $query->get()->map(fn($m) => $sm->add($m));
        }

        return $sm;
    }
}
