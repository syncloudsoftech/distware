<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UpdateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'version' => fake()->unique()->semver(),
            'changelog' => fake()->boolean ? fake()->paragraph : null,
            'published' => fake()->boolean(75),
            'downloads' => fake()->boolean(75) ? fake()->numberBetween(0, 999) : null,
        ];
    }
}
