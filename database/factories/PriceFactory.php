<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'guid' => $this->faker->unique()->uuid(),
            'amount' => $this->faker->numberBetween(100, 50000000) / 100,
            'last_updated_at' => 0
        ];
    }
}
