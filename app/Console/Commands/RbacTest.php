<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RbacTest extends Command
{
    protected $signature = 'rbac:test';
    protected $description = 'Test RBAC system - Display roles, permissions, and users';

    public function handle()
    {
        $this->info('🔐 RBAC System Test');
        $this->newLine();

        // Display Roles
        $this->info('👑 ROLES:');
        $roles = Role::with('permissions')->get();
        foreach ($roles as $role) {
            $this->line("  • {$role->name} ({$role->permissions->count()} permissions)");
        }
        $this->newLine();

        // Display Permissions
        $this->info('🔑 PERMISSIONS:');
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $this->line("  • {$permission->name}");
        }
        $this->newLine();

        // Display Users
        $this->info('👥 USERS:');
        $users = User::with('roles')->get();
        if ($users->isEmpty()) {
            $this->warn('  No users found. Register a user first!');
        } else {
            foreach ($users as $user) {
                $roleNames = $user->roles->pluck('name')->join(', ') ?: 'No roles';
                $this->line("  • {$user->name} ({$user->email}) - Roles: {$roleNames}");
            }
        }
        $this->newLine();

        // Quick Actions
        if ($users->isNotEmpty()) {
            if ($this->confirm('Make first user Super Admin?', false)) {
                $firstUser = $users->first();
                $firstUser->syncRoles(['Super Admin']);
                $this->info("✅ {$firstUser->name} is now Super Admin!");
            }
        }

        $this->info('✨ Test complete!');
        return 0;
    }
}
