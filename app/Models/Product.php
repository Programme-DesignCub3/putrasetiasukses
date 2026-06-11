<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use InteractsWithMedia;

    public const MainImageCollection = 'main_image';

    public const GalleryCollection = 'gallery';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category',
        'name',
        'slug',
        'description',
        'main_image_url',
        'gallery_images',
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
        $this->addMediaCollection(self::MainImageCollection)
            ->singleFile();

        $this->addMediaCollection(self::GalleryCollection);
    }

    public function getMainImageUrlAttribute(?string $value): string
    {
        return $this->getFirstMediaUrl(self::MainImageCollection) ?: (string) $value;
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

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function defaults(): array
    {
        return [
            [
                'category' => 'Steel Plate',
                'name' => 'Plat Hitam',
                'slug' => 'plat-hitam',
                'description' => "Plat baja hitam adalah lembaran baja struktural berdensitas tinggi yang diproduksi melalui proses canai panas (hot-rolled), sehingga menghasilkan ciri khas permukaan berwarna gelap kehitaman. Material ini dikenal memiliki kekuatan tarik yang tinggi, tangguh, dan mudah dibentuk maupun dilas untuk berbagai kebutuhan konstruksi dan fabrikasi.\n\nKami menyediakan plat baja hitam dalam berbagai pilihan ketebalan mulai dari 1,2 mm hingga puluhan milimeter, dengan ukuran standar seperti 4x8 feet, 5x10 feet, dan custom sesuai kebutuhan proyek.",
                'main_image_url' => 'https://placehold.co/860x620/2b2b2b/ffffff?text=Plat+Hitam',
                'gallery_images' => [
                    ['url' => 'https://placehold.co/320x180/525252/ffffff?text=Steel+Plate+1'],
                    ['url' => 'https://placehold.co/320x180/737373/ffffff?text=Steel+Plate+2'],
                    ['url' => 'https://placehold.co/320x180/404040/ffffff?text=Steel+Plate+3'],
                ],
                'is_published' => true,
            ],
        ];
    }
}
