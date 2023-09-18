<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->createOne([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'enabled' => true,
            ]);
        $user->save();
        $user->syncRoles(...Role::all());
        User::factory(10)->create();
        User::factory(15)
            ->afterCreating(
                fn (User $user) => $user->assignRole('Staff')
            )
            ->create();
    }
}
