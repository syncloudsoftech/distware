<?php

namespace Database\Seeders;

use App\Models\Update;
use Illuminate\Database\Seeder;

class UpdatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Update::factory(15)->create();
    }
}
