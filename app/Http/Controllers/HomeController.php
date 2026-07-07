<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{
    public function __invoke(SeoMetadataBuilder $metadata): View
    {
        $metadata->build(
            title: __('seo.home.title'),
            description: __('seo.home.description'),
        );

        return view('home', [
            'heroSlides' => $this->heroSlides(),
            'advantages' => $this->advantages(),
            'sectors' => $this->sectors(),
            'testimonials' => Testimonial::query()
                ->where('is_active', true)
                ->ordered()
                ->get(),
            'partners' => Partner::query()
                ->where('is_active', true)
                ->ordered()
                ->get(),
        ]);
    }

    /**
     * @return Collection<int, HeroSlide>
     */
    private function heroSlides()
    {
        return HeroSlide::query()
            ->where('is_active', true)
            ->ordered()
            ->get();
    }

    /**
     * @return array<int, array{title: string, copy: string, icon: string}>
     */
    private function advantages(): array
    {
        $icons = ['warehouse', 'tag', 'clock', 'thumb'];

        return array_map(fn (int $i, string $icon): array => [
            'title' => __("home.advantage_{$i}_title"),
            'copy' => __("home.advantage_{$i}_copy"),
            'icon' => $icon,
        ], range(1, 4), $icons);
    }

    /**
     * @return array<int, array{title: string, copy: string, image: string}>
     */
    private function sectors(): array
    {
        $images = ['sector-1.png', 'sector-2.png', 'sector-3.png'];
        $icons = ['building-2', 'factory', 'warehouse'];

        return array_map(fn (int $i, string $image, string $icon): array => [
            'title' => __("home.sector_{$i}_title"),
            'copy' => __("home.sector_{$i}_copy"),
            'image' => $image,
            'icon' => $icon,
        ], range(1, 3), $images, $icons);
    }
}
