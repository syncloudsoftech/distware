<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class LicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->boolean ? fake()->e164PhoneNumber : null,
            'expires_at' => fake()->dateTimeBetween('- 6 months', '+ 6 months'),
            'status' => fake()->randomElement(array_keys(config('fixtures.license_statuses'))),
            'notes' => fake()->boolean ? fake()->sentence : null,
        ];
    }
}
