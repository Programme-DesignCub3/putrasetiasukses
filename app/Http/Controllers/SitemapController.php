<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\Article;
use App\Models\Product;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $sitemap = Sitemap::create();

        $this->addLocalizedUrl($sitemap, 'home', priority: 1.0);
        $this->addLocalizedUrl($sitemap, 'about', lastModificationDate: $this->latestTimestamp(AboutPage::query()->max('updated_at')), priority: 0.8);
        $this->addLocalizedUrl($sitemap, 'articles.index', lastModificationDate: $this->latestTimestamp(Article::query()->max('updated_at')), priority: 0.7);
        $this->addLocalizedUrl($sitemap, 'contact', priority: 0.6);

        Product::query()
            ->where('is_published', true)
            ->ordered()
            ->get()
            ->each(fn (Product $product) => $this->addLocalizedUrl(
                $sitemap,
                'products.show',
                ['product' => $product],
                $product->updated_at,
                0.9
            ));

        Article::query()
            ->where('is_published', true)
            ->latest('published_at')
            ->get()
            ->each(fn (Article $article) => $this->addLocalizedUrl(
                $sitemap,
                'articles.show',
                ['article' => $article],
                $article->updated_at ?? $article->published_at,
                0.7
            ));

        return response($sitemap->render(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    private function addLocalizedUrl(
        Sitemap $sitemap,
        string $routeName,
        array $parameters = [],
        ?DateTimeInterface $lastModificationDate = null,
        float $priority = 0.5,
    ): void {
        $locales = config('localizer.supported_locales', ['id']);
        $defaultLocale = $locales[0] ?? 'id';
        $currentLocale = App::getLocale();
        $urls = [];

        foreach ($locales as $locale) {
            $urls[$locale] = $this->localizedRoute($routeName, $parameters, $locale);
        }

        $url = Url::create($urls[$defaultLocale])
            ->setPriority($priority)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY);

        if ($lastModificationDate instanceof DateTimeInterface) {
            $url->setLastModificationDate($lastModificationDate);
        }

        foreach ($urls as $locale => $localizedUrl) {
            $url->addAlternate($localizedUrl, $this->hreflang($locale));
        }

        $url->addAlternate($urls[$defaultLocale], 'x-default');
        $sitemap->add($url);

        App::setLocale($currentLocale);
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    private function localizedRoute(string $routeName, array $parameters, string $locale): string
    {
        App::setLocale($locale);

        return route($routeName, [
            ...$parameters,
            'locale' => $locale,
        ]);
    }

    private function hreflang(string $locale): string
    {
        return match ($locale) {
            'zh' => 'zh-CN',
            'en' => 'en',
            default => 'id',
        };
    }

    private function latestTimestamp(mixed $value): ?DateTimeInterface
    {
        if ($value instanceof DateTimeInterface) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            return Carbon::parse($value);
        }

        return null;
    }
}
