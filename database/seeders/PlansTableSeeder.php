<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::query()
            ->firstOrCreate(
                ['name' => 'Solo'],
                [
                    'entitlements' => ['months' => 1],
                    'published' => true,
                ]
            );
        Plan::query()
            ->firstOrCreate(
                ['name' => 'Professional'],
                [
                    'entitlements' => ['months' => 3],
                    'published' => true,
                ]
            );
        Plan::query()
            ->firstOrCreate(
                ['name' => 'Enterprise'],
                [
                    'entitlements' => ['months' => 12],
                    'published' => true,
                ]
            );
        Plan::query()
            ->firstOrCreate(
                ['name' => 'Custom'],
                [
                    'entitlements' => ['months' => 12 * 10],
                    'published' => false,
                ]
            );
    }
}
