<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        Category::factory()->create([
            'type' => Category::TypeProduct,
            'name' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
        ]);

        Category::factory()->create([
            'type' => Category::TypeProduct,
            'name' => ['id' => 'Besi Beton', 'en' => 'Rebar', 'zh' => '钢筋'],
        ]);

        Category::factory()->create([
            'type' => Category::TypeArticle,
            'name' => ['id' => 'Industri & Konstruksi', 'en' => 'Industry & Construction', 'zh' => '工业与建筑'],
        ]);

        Category::factory()->create([
            'type' => Category::TypeArticle,
            'name' => ['id' => 'Tips & Panduan', 'en' => 'Tips & Guides', 'zh' => '提示与指南'],
        ]);

        Product::factory()->count(4)->create();

        Article::factory()->count(3)->create();

        ContactMessage::factory()->create([
            'name' => 'Budi Santoso',
            'company' => 'PT Konstruksi Maju',
            'phone' => '081234567890',
            'email' => 'budi@example.com',
            'subject' => 'Permintaan Harga Plat Baja',
            'message' => 'Mohon info harga dan ketersediaan plat baja ukuran 10mm.',
        ]);

        ContactMessage::factory()->create([
            'name' => 'John Doe',
            'company' => 'Steel Works Inc',
            'phone' => '+628123456789',
            'email' => 'john@example.com',
            'subject' => 'Inquiry about Rebar',
            'message' => 'We need a quote for 500 tons of rebar.',
            'read_at' => now()->subDay(),
        ]);
    }
}
