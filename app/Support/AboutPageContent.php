<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class AboutPageContent
{
    /**
     * @param  array<int, array{url: string, alt: string}>  $gallery_images
     */
    public function __construct(
        public string $intro_text,
        public string $vision_body,
        public string $mission_body,
        public string $hero_image_url,
        public string $intro_image_url,
        public array $gallery_images,
        public ?string $video_url,
    ) {}

    public static function current(): self
    {
        $about = safe_db_config('website.about', []);

        return new self(
            intro_text: __('site.intro_text'),
            vision_body: __('site.vision_body'),
            mission_body: __('site.mission_body'),
            hero_image_url: self::imageUrl($about['hero_image'] ?? null),
            intro_image_url: self::imageUrl($about['intro_image'] ?? null),
            gallery_images: self::galleryImages($about['gallery_images'] ?? null),
            video_url: filled($about['video_url'] ?? null) ? (string) $about['video_url'] : null,
        );
    }

    private static function imageUrl(mixed $value): string
    {
        if (is_array($value)) {
            $value = collect($value)->first();
        }

        $path = (string) $value;

        if ($path === '' || str_starts_with($path, 'http') || str_starts_with($path, '/')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * @return array<int, array{url: string, alt: string}>
     */
    private static function galleryImages(mixed $images): array
    {
        if (! is_array($images)) {
            return [];
        }

        return collect($images)
            ->map(function (mixed $image): ?array {
                $path = is_array($image) ? ($image['url'] ?? $image['path'] ?? null) : $image;
                $url = self::imageUrl($path);

                if ($url === '') {
                    return null;
                }

                return [
                    'url' => $url,
                    'alt' => is_array($image) && filled($image['alt'] ?? null) ? (string) $image['alt'] : 'Galeri material baja',
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
