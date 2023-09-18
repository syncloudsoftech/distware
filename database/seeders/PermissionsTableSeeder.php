<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::query()->firstOrCreate(['name' => 'view all licenses']);
        Permission::query()->firstOrCreate(['name' => 'view license']);
        Permission::query()->firstOrCreate(['name' => 'create license']);
        Permission::query()->firstOrCreate(['name' => 'update license']);
        Permission::query()->firstOrCreate(['name' => 'delete license']);

        Permission::query()->firstOrCreate(['name' => 'view all plans']);
        Permission::query()->firstOrCreate(['name' => 'view plan']);
        Permission::query()->firstOrCreate(['name' => 'create plan']);
        Permission::query()->firstOrCreate(['name' => 'update plan']);
        Permission::query()->firstOrCreate(['name' => 'delete plan']);

        Permission::query()->firstOrCreate(['name' => 'view all roles']);
        Permission::query()->firstOrCreate(['name' => 'view role']);
        Permission::query()->firstOrCreate(['name' => 'create role']);
        Permission::query()->firstOrCreate(['name' => 'update role']);
        Permission::query()->firstOrCreate(['name' => 'delete role']);

        Permission::query()->firstOrCreate(['name' => 'view all updates']);
        Permission::query()->firstOrCreate(['name' => 'view update']);
        Permission::query()->firstOrCreate(['name' => 'create update']);
        Permission::query()->firstOrCreate(['name' => 'update update']);
        Permission::query()->firstOrCreate(['name' => 'delete update']);

        Permission::query()->firstOrCreate(['name' => 'view all users']);
        Permission::query()->firstOrCreate(['name' => 'view user']);
        Permission::query()->firstOrCreate(['name' => 'create user']);
        Permission::query()->firstOrCreate(['name' => 'update user']);
        Permission::query()->firstOrCreate(['name' => 'delete user']);

        Permission::query()->firstOrCreate(['name' => 'access horizon']);
    }
}
