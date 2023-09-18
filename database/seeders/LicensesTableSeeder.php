<?php

namespace Database\Seeders;

use App\Models\License;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class LicensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = Plan::query()->get();
        License::factory(25)
            ->state(new Sequence(
                fn (Sequence $sequence) => ['plan_id' => $plans->random()->getKey()],
            ))
            ->create();
    }
}
