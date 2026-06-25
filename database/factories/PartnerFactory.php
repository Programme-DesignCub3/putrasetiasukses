<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'initial' => strtoupper(fake()->randomLetter()),
            'color' => fake()->hexColor(),
            'is_active' => true,
        ];
    }
}
