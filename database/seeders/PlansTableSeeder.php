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
                    'entitlements' => ['feature_1'],
                    'published' => true,
                ]
            );
        Plan::query()
            ->firstOrCreate(
                ['name' => 'Professional'],
                [
                    'entitlements' => [
                        'feature_1',
                        'feature_2',
                    ],
                    'published' => true,
                ]
            );
        Plan::query()
            ->firstOrCreate(
                ['name' => 'Enterprise'],
                [
                    'entitlements' => [
                        'feature_1',
                        'feature_2',
                        'feature_3',
                    ],
                    'published' => true,
                ]
            );
        Plan::query()
            ->firstOrCreate(
                ['name' => 'Custom'],
                [
                    'entitlements' => [
                        'feature_1',
                        'feature_2',
                        'feature_3',
                        'feature_4',
                    ],
                    'published' => false,
                ]
            );
    }
}
