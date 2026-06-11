<?php

namespace App\Models;

use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Article extends Model implements HasMedia
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    use HasSlug;
    use HasTranslations;
    use InteractsWithMedia;

    public const ImageCollection = 'article_image';

    /**
     * @var list<string>
     */
    public array $translatable = [
        'category',
        'title',
        'excerpt',
        'body',
    ];

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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn (Article $article): string => $article->getTranslation('title', 'id', false) ?: '')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * @return BelongsToMany<Category, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getCategoryNamesAttribute(): string
    {
        if ($this->relationLoaded('categories') && $this->categories->isNotEmpty()) {
            return $this->categories
                ->pluck('name')
                ->filter()
                ->implode(', ');
        }

        return (string) $this->category;
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
                'category' => [
                    'id' => 'Industri & Konstruksi',
                    'en' => 'Industry & Construction',
                    'zh' => '工业与建筑',
                ],
                'title' => [
                    'id' => 'Perkembangan Industri Baja di Indonesia dan Peluang Masa Depan',
                    'en' => 'The Growth of Indonesia Steel Industry and Future Opportunities',
                    'zh' => '印度尼西亚钢铁行业发展与未来机遇',
                ],
                'slug' => 'perkembangan-industri-baja-indonesia',
                'author' => 'Heri Pradana',
                'image_url' => 'https://placehold.co/1180x560/4b5563/ffffff?text=Industri+Baja',
                'excerpt' => [
                    'id' => 'Industri baja Indonesia terus berkembang seiring pembangunan infrastruktur dan kebutuhan material proyek nasional.',
                    'en' => 'Indonesia steel industry keeps growing alongside infrastructure development and national project material demand.',
                    'zh' => '随着基础设施建设和国家项目材料需求增长，印度尼西亚钢铁行业持续发展。',
                ],
                'body' => [
                    'id' => $body,
                    'en' => $body,
                    'zh' => $body,
                ],
                'published_at' => now(),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'category' => [
                    'id' => 'Tips & Panduan',
                    'en' => 'Tips & Guides',
                    'zh' => '提示与指南',
                ],
                'title' => [
                    'id' => 'Panduan Memilih Material Baja Berkualitas untuk Konstruksi',
                    'en' => 'Guide to Choosing Quality Steel Materials for Construction',
                    'zh' => '建筑用优质钢材选择指南',
                ],
                'slug' => 'panduan-memilih-material-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/720x480/374151/ffffff?text=Material+Baja',
                'excerpt' => [
                    'id' => 'Kenali faktor penting saat memilih material baja untuk kebutuhan konstruksi.',
                    'en' => 'Understand key factors when selecting steel materials for construction needs.',
                    'zh' => '了解选择建筑用钢材时的重要因素。',
                ],
                'body' => ['id' => $body, 'en' => $body, 'zh' => $body],
                'published_at' => now()->subDays(1),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'category' => ['id' => 'Produk & Material', 'en' => 'Products & Materials', 'zh' => '产品与材料'],
                'title' => [
                    'id' => 'Keunggulan Stainless Steel Dibanding Material Lain',
                    'en' => 'Advantages of Stainless Steel Compared to Other Materials',
                    'zh' => '不锈钢相比其他材料的优势',
                ],
                'slug' => 'keunggulan-stainless-steel',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/71717a/ffffff?text=Stainless+Steel',
                'excerpt' => ['id' => 'Stainless steel memiliki ketahanan korosi dan tampilan bersih untuk banyak kebutuhan.', 'en' => 'Stainless steel offers corrosion resistance and a clean appearance for many needs.', 'zh' => '不锈钢具有耐腐蚀性和整洁外观，适合多种用途。'],
                'body' => ['id' => $body, 'en' => $body, 'zh' => $body],
                'published_at' => now()->subDays(2),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => ['id' => 'Industri & Konstruksi', 'en' => 'Industry & Construction', 'zh' => '工业与建筑'],
                'title' => ['id' => 'Pengaruh Harga Baja terhadap Industri Konstruksi', 'en' => 'The Impact of Steel Prices on Construction Industry', 'zh' => '钢材价格对建筑行业的影响'],
                'slug' => 'pengaruh-harga-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/6b7280/ffffff?text=Harga+Baja',
                'excerpt' => ['id' => 'Harga baja memengaruhi biaya proyek dan strategi pengadaan material.', 'en' => 'Steel prices influence project costs and material procurement strategy.', 'zh' => '钢材价格会影响项目成本和材料采购策略。'],
                'body' => ['id' => $body, 'en' => $body, 'zh' => $body],
                'published_at' => now()->subDays(3),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => ['id' => 'Industri & Konstruksi', 'en' => 'Industry & Construction', 'zh' => '工业与建筑'],
                'title' => ['id' => 'Standar Sertifikasi Material Baja di Indonesia', 'en' => 'Steel Material Certification Standards in Indonesia', 'zh' => '印度尼西亚钢材认证标准'],
                'slug' => 'standar-sertifikasi-material-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/52525b/ffffff?text=Sertifikasi+Baja',
                'excerpt' => ['id' => 'Sertifikasi memastikan material baja memenuhi standar mutu dan keamanan.', 'en' => 'Certification ensures steel materials meet quality and safety standards.', 'zh' => '认证确保钢材符合质量和安全标准。'],
                'body' => ['id' => $body, 'en' => $body, 'zh' => $body],
                'published_at' => now()->subDays(4),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => ['id' => 'Produk & Material', 'en' => 'Products & Materials', 'zh' => '产品与材料'],
                'title' => ['id' => 'Proses Produksi Baja: Dari Bahan Mentah hingga Siap Digunakan', 'en' => 'Steel Production Process: From Raw Material to Ready Use', 'zh' => '钢材生产流程：从原料到可使用材料'],
                'slug' => 'proses-produksi-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/991b1b/ffffff?text=Produksi+Baja',
                'excerpt' => ['id' => 'Proses produksi baja melewati beberapa tahap penting sebelum digunakan.', 'en' => 'Steel production passes several important stages before it is ready to use.', 'zh' => '钢材生产在投入使用前需要经过多个重要阶段。'],
                'body' => ['id' => $body, 'en' => $body, 'zh' => $body],
                'published_at' => now()->subDays(5),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => ['id' => 'Produk & Material', 'en' => 'Products & Materials', 'zh' => '产品与材料'],
                'title' => ['id' => 'Tips Perawatan Material Baja agar Tahan Lama', 'en' => 'Steel Material Maintenance Tips for Longer Durability', 'zh' => '延长钢材寿命的维护技巧'],
                'slug' => 'tips-perawatan-material-baja',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/78716c/ffffff?text=Perawatan+Baja',
                'excerpt' => ['id' => 'Perawatan yang tepat membantu material baja lebih awet dalam penggunaan jangka panjang.', 'en' => 'Proper maintenance helps steel materials last longer in long-term use.', 'zh' => '正确维护可帮助钢材在长期使用中更加耐久。'],
                'body' => ['id' => $body, 'en' => $body, 'zh' => $body],
                'published_at' => now()->subDays(6),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'category' => ['id' => 'Industri & Konstruksi', 'en' => 'Industry & Construction', 'zh' => '工业与建筑'],
                'title' => ['id' => 'Fungsi Baja Ringan untuk Bangunan Modern', 'en' => 'Light Steel Functions for Modern Buildings', 'zh' => '轻钢在现代建筑中的作用'],
                'slug' => 'fungsi-baja-ringan',
                'author' => 'Admin',
                'image_url' => 'https://placehold.co/640x420/64748b/ffffff?text=Baja+Ringan',
                'excerpt' => ['id' => 'Baja ringan banyak dipakai karena efisien, kuat, dan mudah diaplikasikan.', 'en' => 'Light steel is widely used because it is efficient, strong, and easy to apply.', 'zh' => '轻钢因高效、坚固且易于应用而被广泛使用。'],
                'body' => ['id' => $body, 'en' => $body, 'zh' => $body],
                'published_at' => now()->subDays(7),
                'is_featured' => false,
                'is_published' => true,
            ],
        ];
    }
}
