<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fingerprint' => Str::uuid()->toString(),
            'platform' => fake()->randomElement([
                fake()->linuxPlatformToken,
                fake()->macPlatformToken,
                fake()->windowsPlatformToken,
            ]),
            'ip' => fake()->ipv4,
            'last_active_at' => fake()->dateTimeBetween('- 6 months', '+ 6 months'),
        ];
    }
}
