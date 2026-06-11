<?php

namespace App\Models;

use App\Support\SiteConfig;
use Database\Factories\AboutPageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class AboutPage extends Model implements HasMedia
{
    /** @use HasFactory<AboutPageFactory> */
    use HasFactory;

    use HasTranslations;
    use InteractsWithMedia;

    public const HeroImageCollection = 'hero_image';

    public const IntroImageCollection = 'intro_image';

    public const GalleryCollection = 'gallery';

    /**
     * @var list<string>
     */
    public array $translatable = [
        'title',
        'intro_text',
        'vision_title',
        'vision_body',
        'mission_title',
        'mission_body',
        'video_title',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'hero_image_url',
        'intro_image_url',
        'intro_text',
        'vision_title',
        'vision_body',
        'mission_title',
        'mission_body',
        'gallery_images',
        'video_title',
        'video_url',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'is_published' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::HeroImageCollection)
            ->singleFile();

        $this->addMediaCollection(self::IntroImageCollection)
            ->singleFile();

        $this->addMediaCollection(self::GalleryCollection);
    }

    public function getHeroImageUrlAttribute(?string $value): string
    {
        return $this->getFirstMediaUrl(self::HeroImageCollection) ?: (string) $value;
    }

    public function getIntroImageUrlAttribute(?string $value): string
    {
        return $this->getFirstMediaUrl(self::IntroImageCollection) ?: (string) $value;
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getGalleryImagesAttribute(?string $value): array
    {
        if ($this->hasMedia(self::GalleryCollection)) {
            return $this->getMedia(self::GalleryCollection)
                ->map(fn (Media $media): array => [
                    'url' => $media->getUrl(),
                    'alt' => $media->name,
                ])
                ->all();
        }

        return json_decode((string) $value, true) ?: [];
    }

    public static function published(): self
    {
        $page = self::query()
            ->where('is_published', true)
            ->latest()
            ->firstOrCreate([], self::defaults());

        return $page->load('media');
    }

    /**
     * @return array<string, mixed>
     */
    public static function defaults(): array
    {
        return [
            'title' => [
                'id' => 'Tentang Kami',
                'en' => 'About Us',
                'zh' => '关于我们',
            ],
            'hero_image_url' => 'https://placehold.co/1400x320/8b0000/ffffff?text=Tentang+Kami',
            'intro_image_url' => 'https://placehold.co/520x640/5f6872/ffffff?text=Plat+Baja',
            'intro_text' => [
                'id' => 'PT Putra Setia Sukses Bersama adalah stockist dan distributor material besi dan baja yang melayani kebutuhan konstruksi, manufaktur, pergudangan, dan proyek industri.',
                'en' => 'PT Putra Setia Sukses Bersama is a stockist and distributor of iron and steel materials serving construction, manufacturing, warehousing, and industrial project needs.',
                'zh' => 'PT Putra Setia Sukses Bersama 是钢铁材料库存商与经销商，服务建筑、制造、仓储和工业项目需求。',
            ],
            'vision_title' => SiteConfig::translations('Visi'),
            'vision_body' => [
                'id' => 'Menjadi mitra penyedia material besi dan baja yang terpercaya, konsisten, dan responsif bagi pelanggan di seluruh Indonesia.',
                'en' => 'To become a trusted, consistent, and responsive iron and steel material partner for customers across Indonesia.',
                'zh' => '成为印度尼西亚客户值得信赖、稳定且响应迅速的钢铁材料合作伙伴。',
            ],
            'mission_title' => [
                'id' => 'Misi',
                'en' => 'Mission',
                'zh' => '使命',
            ],
            'mission_body' => [
                'id' => 'Menjaga ketersediaan stok, memberikan kualitas material terbaik, menawarkan harga kompetitif, dan mengirim pesanan tepat waktu sesuai kebutuhan pelanggan.',
                'en' => 'Maintain stock availability, provide the best material quality, offer competitive pricing, and deliver orders on time according to customer needs.',
                'zh' => '保持库存供应，提供优质材料，给出有竞争力的价格，并按客户需求准时交付订单。',
            ],
            'gallery_images' => [
                ['url' => 'https://placehold.co/640x420/8aaee0/ffffff?text=Construction'],
                ['url' => 'https://placehold.co/640x420/71717a/ffffff?text=Steel+Plate'],
                ['url' => 'https://placehold.co/640x420/6b7280/ffffff?text=Automotive'],
                ['url' => 'https://placehold.co/640x420/4b5563/ffffff?text=Warehouse'],
            ],
            'video_title' => SiteConfig::translations('Video'),
            'video_url' => null,
            'is_published' => true,
        ];
    }
}
