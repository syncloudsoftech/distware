<?php

namespace Database\Seeders;

use App\Models\License;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class MachinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $licences = License::query()->get();
        Machine::factory(25)
            ->state(new Sequence(
                fn (Sequence $sequence) => ['license_id' => $licences->random()->getKey()],
            ))
            ->create();
    }
}
