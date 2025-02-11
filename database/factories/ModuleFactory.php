<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'width' => $this->faker->randomElement(['100px', '50%', '10rem']),
            'height' => $this->faker->randomElement(['100px', '50%', '10rem']),
            'color' => $this->faker->hexColor(),
            'link' => $this->faker->url(),
        ];
    }
}
