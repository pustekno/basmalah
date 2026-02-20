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
            
            // Budget
            'view budgets',
            'manage budgets',
            
            // Goals
            'view goals',
            'manage goals',
            
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
            'view budgets',
            'manage budgets',
            'view goals',
            'manage goals',
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
    }
}
