<?php

namespace App\Models;

use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    use InteractsWithMedia;

    public const ImageCollection = 'article_image';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category',
        'title',
        'slug',
        'author',
        'image_url',
        'excerpt',
        'body',
        'published_at',
        'is_featured',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::ImageCollection)
            ->singleFile();
    }

    public function getImageUrlAttribute(?string $value): string
    {
        return $this->getFirstMediaUrl(self::ImageCollection) ?: (string) $value;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function defaults(): array
    {
        $body = "Industri baja di Indonesia terus menunjukkan perkembangan yang signifikan dalam beberapa tahun terakhir seiring meningkatnya pembangunan infrastruktur, kawasan industri, properti, hingga sektor manufaktur nasional. Permintaan terhadap material baja mengalami pertumbuhan yang stabil, terutama untuk kebutuhan konstruksi gedung bertingkat, jalan tol, jembatan, pelabuhan, dan proyek energi.\n\nDi sisi lain, industri baja nasional menghadapi sejumlah tantangan yang tidak ringan, mulai dari fluktuasi harga bahan baku global, tingginya biaya energi produksi, hingga masuknya produk impor dengan harga yang lebih murah. Meski demikian, peluang pertumbuhan industri baja Indonesia masih dinilai sangat besar mengingat kebutuhan pembangunan nasional yang terus meningkat setiap tahunnya.\n\nKe depan, industri baja Indonesia diproyeksikan akan memainkan peran strategis dalam mendukung pertumbuhan ekonomi nasional, terutama dalam menghadapi percepatan pembangunan kawasan industri dan proyek infrastruktur berkelanjutan lainnya.";

        return [
            [
                'category' => 'Industri & Konstruksi',
                'title' => 'Perkembangan Industri Baja di Indonesia dan Peluang Masa Depan',
                'slug' => 'perkembangan-industri-baja-indonesia',
                'author' => 'Heri Pradana',
                'image_url' => 'https://placehold.co/1180x560/4b5563/ffffff?text=Industri+Baja',
                'excerpt' => 'Industri baja Indonesia terus berkembang seiring pembangunan infrastruktur dan kebutuhan material proyek nasional.',
                'body' => $body,
                'published_at' => now(),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'category' => 'Tips & Panduan',
                'title' => 'Panduan Memilih Material Baja Berkualitas untuk Konstruksi',
                'slug' => 'panduan-memilih-material-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/720x480/374151/ffffff?text=Material+Baja',
                'excerpt' => 'Kenali faktor penting saat memilih material baja untuk kebutuhan konstruksi.',
                'body' => $body,
                'published_at' => now()->subDays(1),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'category' => 'Produk & Material',
                'title' => 'Keunggulan Stainless Steel Dibanding Material Lain',
                'slug' => 'keunggulan-stainless-steel',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/71717a/ffffff?text=Stainless+Steel',
                'excerpt' => 'Stainless steel memiliki ketahanan korosi dan tampilan bersih untuk banyak kebutuhan.',
                'body' => $body,
                'published_at' => now()->subDays(2),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => 'Industri & Konstruksi',
                'title' => 'Pengaruh Harga Baja terhadap Industri Konstruksi',
                'slug' => 'pengaruh-harga-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/6b7280/ffffff?text=Harga+Baja',
                'excerpt' => 'Harga baja memengaruhi biaya proyek dan strategi pengadaan material.',
                'body' => $body,
                'published_at' => now()->subDays(3),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => 'Industri & Konstruksi',
                'title' => 'Standar Sertifikasi Material Baja di Indonesia',
                'slug' => 'standar-sertifikasi-material-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/52525b/ffffff?text=Sertifikasi+Baja',
                'excerpt' => 'Sertifikasi memastikan material baja memenuhi standar mutu dan keamanan.',
                'body' => $body,
                'published_at' => now()->subDays(4),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => 'Produk & Material',
                'title' => 'Proses Produksi Baja: Dari Bahan Mentah hingga Siap Digunakan',
                'slug' => 'proses-produksi-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/991b1b/ffffff?text=Produksi+Baja',
                'excerpt' => 'Proses produksi baja melewati beberapa tahap penting sebelum digunakan.',
                'body' => $body,
                'published_at' => now()->subDays(5),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => 'Produk & Material',
                'title' => 'Tips Perawatan Material Baja agar Tahan Lama',
                'slug' => 'tips-perawatan-material-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/78716c/ffffff?text=Perawatan+Baja',
                'excerpt' => 'Perawatan yang tepat membantu material baja lebih awet dalam penggunaan jangka panjang.',
                'body' => $body,
                'published_at' => now()->subDays(6),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => 'Industri & Konstruksi',
                'title' => 'Fungsi Baja Ringan untuk Bangunan Modern',
                'slug' => 'fungsi-baja-ringan',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/64748b/ffffff?text=Baja+Ringan',
                'excerpt' => 'Baja ringan banyak dipakai karena efisien, kuat, dan mudah diaplikasikan.',
                'body' => $body,
                'published_at' => now()->subDays(7),
                'is_featured' => false,
                'is_published' => true,
            ],
        ];
    }
}
