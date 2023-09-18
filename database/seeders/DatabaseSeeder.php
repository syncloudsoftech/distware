<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(LicensesTableSeeder::class);
        $this->call(MachinesTableSeeder::class);
        $this->call(UpdatesTableSeeder::class);
    }
}
