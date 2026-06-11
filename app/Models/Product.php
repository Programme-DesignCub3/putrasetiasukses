<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

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
