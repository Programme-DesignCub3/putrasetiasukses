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
        $defaults = SiteConfig::defaults();
        $about = safe_db_config(SiteConfig::Group.'.about', $defaults['about']);

        return new self(
            intro_text: SiteConfig::translated(self::introText()),
            vision_body: SiteConfig::translated(self::visionBody()),
            mission_body: SiteConfig::translated(self::missionBody()),
            hero_image_url: self::imageUrl($about['hero_image'] ?? $defaults['about']['hero_image']),
            intro_image_url: self::imageUrl($about['intro_image'] ?? $defaults['about']['intro_image']),
            gallery_images: self::galleryImages($about['gallery_images'] ?? $defaults['about']['gallery_images']),
            video_url: filled($about['video_url'] ?? null) ? (string) $about['video_url'] : null,
        );
    }

    /**
     * @return array<string, string>
     */
    private static function introText(): array
    {
        return [
            'id' => 'PT Putra Setia Sukses Bersama adalah stockist dan distributor material besi dan baja yang melayani kebutuhan konstruksi, manufaktur, pergudangan, dan proyek industri.',
            'en' => 'PT Putra Setia Sukses Bersama is a stockist and distributor of iron and steel materials serving construction, manufacturing, warehousing, and industrial project needs.',
        ];
    }

    /**
     * @return array<string, string>
     */
    private static function visionBody(): array
    {
        return [
            'id' => 'Menjadi mitra penyedia material besi dan baja yang terpercaya, konsisten, dan responsif bagi pelanggan di seluruh Indonesia.',
            'en' => 'To become a trusted, consistent, and responsive iron and steel material partner for customers across Indonesia.',
        ];
    }

    /**
     * @return array<string, string>
     */
    private static function missionBody(): array
    {
        return [
            'id' => 'Menjaga ketersediaan stok, memberikan kualitas material terbaik, menawarkan harga kompetitif, dan mengirim pesanan tepat waktu sesuai kebutuhan pelanggan.',
            'en' => 'Maintain stock availability, provide the best material quality, offer competitive pricing, and deliver orders on time according to customer needs.',
        ];
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
