<?php

namespace Database\Factories;

use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroSlide>
 */
class HeroSlideFactory extends Factory
{
    public function definition(): array
    {
        return [
            'image' => 'https://placehold.co/1800x720/'.fake()->hexColor().'/ffffff?text='.urlencode(fake()->words(3, true)),
            'label' => fake()->randomElement(['Material Baja Terpercaya', 'Supplier & Distributor', 'Kualitas Terjamin']),
            'title' => fake()->randomElement(['Plat Lembaran Baja', 'Distributor Terpercaya', 'Kualitas Terbaik']),
            'subtitle' => fake()->randomElement(['Plat Hitam - Plat Putih - Plat Galvanil', 'Pengiriman ke Seluruh Indonesia', 'Standar Mutu Internasional']),
            'is_active' => true,
        ];
    }
}
