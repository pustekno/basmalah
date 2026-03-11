<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Transactions
            'view transactions',
            'create transactions',
            'edit transactions',
            'delete transactions',
            
            // Accounts
            'view accounts',
            'manage accounts',
            
            // Categories
            'view categories',
            'manage categories',
            
            // Budget
            'view budgets',
            'manage budgets',
            
            // Goals
            'view goals',
            'manage goals',
            
            // Calendar
            'view calendar',
            
            // Reports
            'view reports',
            
            // Users
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
            'view transactions',
            'create transactions',
            'edit transactions',
            'delete transactions',
            'view accounts',
            'manage accounts',
            'view categories',
            'manage categories',
            'view budgets',
            'manage budgets',
            'view goals',
            'manage goals',
            'view calendar',
            'view reports',
        ]);

        $bendahara = Role::firstOrCreate(['name' => 'Bendahara', 'guard_name' => 'web']);
        $bendahara->syncPermissions([
            'view transactions',
            'create transactions',
            'edit transactions',
            'view accounts',
            'view reports',
        ]);

        $viewer = Role::firstOrCreate(['name' => 'Viewer', 'guard_name' => 'web']);
        $viewer->syncPermissions(['view reports']);

        // Assign Super Admin role to first user
        $firstUser = User::first();
        if ($firstUser && !$firstUser->hasAnyRole(['Super Admin', 'Admin', 'Bendahara', 'Viewer'])) {
            $firstUser->assignRole('Super Admin');
        }

        // Create test users for each role (if not exists)
        $this->createTestUsers();
    }

    private function createTestUsers(): void
    {
        // Get masjids
        $masjid1 = \App\Models\Masjid::where('nama', 'Masjid Al-Ikhlas')->first();
        $masjid2 = \App\Models\Masjid::where('nama', 'Masjid An-Nur')->first();
        $masjid3 = \App\Models\Masjid::where('nama', 'Masjid At-Taqwa')->first();

        // Super Admin User (no masjid - can see all)
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@basmallah.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'masjid_id' => null, // Super Admin tidak terikat ke masjid tertentu
            ]
        );
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole('Super Admin');
        }

        // Admin User - Masjid Al-Ikhlas
        $admin = User::firstOrCreate(
            ['email' => 'admin@basmallah.com'],
            [
                'name' => 'Admin Masjid Al-Ikhlas',
                'password' => bcrypt('password'),
                'masjid_id' => $masjid1?->id,
            ]
        );
        if (!$admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        // Bendahara User - Masjid An-Nur
        $bendahara = User::firstOrCreate(
            ['email' => 'bendahara@basmallah.com'],
            [
                'name' => 'Bendahara Masjid An-Nur',
                'password' => bcrypt('password'),
                'masjid_id' => $masjid2?->id,
            ]
        );
        if (!$bendahara->hasRole('Bendahara')) {
            $bendahara->assignRole('Bendahara');
        }

        // Viewer User - No specific masjid (can see all)
        $viewer = User::firstOrCreate(
            ['email' => 'viewer@basmallah.com'],
            [
                'name' => 'Viewer Jemaah',
                'password' => bcrypt('password'),
                'masjid_id' => null, // Viewer tidak terikat ke masjid tertentu
            ]
        );
        if (!$viewer->hasRole('Viewer')) {
            $viewer->assignRole('Viewer');
        }
        // Update existing viewer to have null masjid_id
        $viewer->update(['masjid_id' => null]);

        // Additional users for each masjid
        // Admin for Masjid An-Nur
        $admin2 = User::firstOrCreate(
            ['email' => 'admin.annur@basmallah.com'],
            [
                'name' => 'Admin Masjid An-Nur',
                'password' => bcrypt('password'),
                'masjid_id' => $masjid2?->id,
            ]
        );
        if (!$admin2->hasRole('Admin')) {
            $admin2->assignRole('Admin');
        }

        // Admin for Masjid At-Taqwa
        $admin3 = User::firstOrCreate(
            ['email' => 'admin.attaqwa@basmallah.com'],
            [
                'name' => 'Admin Masjid At-Taqwa',
                'password' => bcrypt('password'),
                'masjid_id' => $masjid3?->id,
            ]
        );
        if (!$admin3->hasRole('Admin')) {
            $admin3->assignRole('Admin');
        }
    }
}
