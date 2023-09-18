<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Role $administrator */
        $administrator = Role::query()->firstOrCreate(['name' => 'Administrator']);
        $administrator->givePermissionTo(
            'access horizon',
            'delete license',
            'create plan',
            'update plan',
            'delete plan',
            'view all roles',
            'view role',
            'create role',
            'update role',
            'delete role',
            'create update',
            'update update',
            'delete update',
            'delete user'
        );
        /** @var Role $staff */
        $staff = Role::query()->firstOrCreate(['name' => 'Staff']);
        $staff->givePermissionTo(
            'view all licenses',
            'view license',
            'create license',
            'update license',
            'view all plans',
            'view plan',
            'view all updates',
            'view update',
            'view all users',
            'view user',
            'create user',
            'update user'
        );
    }
}
