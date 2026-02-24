<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@basmalah.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Ensure Super Admin role exists
        $role = Role::firstOrCreate(['name' => 'Super Admin']);

        // Assign role to user
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole('Super Admin');
        }

        $this->command->info('Super Admin account created successfully!');
        $this->command->info('Email: superadmin@basmalah.com');
        $this->command->info('Password: password');
    }
}
