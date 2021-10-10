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
        $this->urls[$url . http_build_query($params)] = ['url' => $url, 'params' => $params, 'cb' => $cb];
    }

    public function generate()
    {
        $sm = Sitemap::create();

        foreach ($this->urls as $item) {
            $url = Url::create(str_starts_with($item['url'], 'http') ? $item['url']
                : route($item['url'], $item['params']));
            $item['cb'] && $item['cb']($url);
            $sm->add($url);
        }

        foreach ($this->models as $class => $query) {
            $query->get()->map(fn($m) => $sm->add($m));
        }

        return $sm;
    }
}
