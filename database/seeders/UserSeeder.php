<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'username' => 'root',
            'fullname' => 'Administrator',
            'email' => 'root@root.com',
            'telp' => '1234567890',
            'birthdate' => '1990-01-01',
            'region' => 'Jakarta',
            'password' => Hash::make('root123')
        ]);

        // Create roles
        Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        $admin->assignRole('superadmin');

        // Create 10 dummy users and assign the 'user' role to them
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
