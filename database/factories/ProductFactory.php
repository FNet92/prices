<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'guid' => $this->faker->unique()->uuid(),
            'name' => $this->faker->name()
        ];
    }
}
