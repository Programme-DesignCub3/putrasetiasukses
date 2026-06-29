<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HeroSlideSeeder::class,
            ProductSeeder::class,
            ArticleSeeder::class,
            TestimonialSeeder::class,
            PartnerSeeder::class,
        ]);

        // User::factory(10)->create();

        User::query()->updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'email_verified_at' => now(),
            ],
        );
    }
}
