# Laravel Authentication & Authorization System - Masjid Basmallah

## 🎯 Overview
Complete Role-Based Access Control (RBAC) system using Laravel Breeze and Spatie Laravel Permission.

## 📦 Installed Packages
- Laravel 12.x
- Laravel Breeze (Authentication)
- Spatie Laravel Permission 6.x

## 👥 Roles Structure

### 1. Super Admin
- Full system access
- All permissions granted
- Can manage users and assign roles

### 2. Admin
- Manage transactions (view, create, edit, delete)
- Manage accounts
- Manage budgets
- Manage goals
- View reports

### 3. Bendahara (Treasurer)
- Create and edit transactions
- View accounts
- View reports

### 4. Viewer
- View reports only

## 🔐 Permissions List

### Transactions
- `view transactions`
- `create transactions`
- `edit transactions`
- `delete transactions`

### Accounts
- `view accounts`
- `manage accounts`

### Budget
- `view budgets`
- `manage budgets`

### Goals
- `view goals`
- `manage goals`

### Reports
- `view reports`

### Users
- `manage users`

## 🚀 Setup Instructions

### 1. Run Seeder
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### 2. Register First User
- Register a new user via `/register`
- First user automatically gets "Viewer" role
- Run seeder to assign "Super Admin" role to first user

### 3. Access Admin Panel
- Login as Super Admin
- Navigate to `/admin/dashboard`
- Manage users at `/admin/users`

## 🛡️ Usage Examples

### In Routes (web.php)
```php
// Role-based protection
Route::middleware(['role:Super Admin'])->group(function () {
    // Super Admin only routes
});

// Permission-based protection
Route::middleware(['permission:view reports'])->group(function () {
    // Routes for users with 'view reports' permission
});

// Multiple roles
Route::middleware(['role:Super Admin|Admin'])->group(function () {
    // Routes for Super Admin OR Admin
});
```

### In Blade Views
```blade
@role('Super Admin')
    <!-- Content for Super Admin only -->
@endrole

@can('view reports')
    <!-- Content for users with 'view reports' permission -->
@endcan

@hasanyrole('Super Admin|Admin')
    <!-- Content for Super Admin or Admin -->
@endhasanyrole
```

### In Controllers
```php
// Check role
if (auth()->user()->hasRole('Super Admin')) {
    // Logic for Super Admin
}

// Check permission
if (auth()->user()->can('view reports')) {
    // Logic for users with permission
}

// Authorize in method
$this->authorize('view reports');
```

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       └── UserController.php
│   └── Requests/
│       └── AssignRoleRequest.php
├── Listeners/
│   └── AssignDefaultRole.php
└── Models/
    └── User.php (with HasRoles trait)

database/
└── seeders/
    └── RolePermissionSeeder.php

resources/
└── views/
    ├── admin/
    │   ├── dashboard.blade.php
    │   └── users/
    │       ├── index.blade.php
    │       └── edit.blade.php
    └── errors/
        └── 403.blade.php

routes/
└── web.php (with protected routes)
```

## 🔒 Security Features

✅ Form Request Validation
✅ Mass Assignment Protection
✅ Middleware Protection
✅ Permission-based System (no hardcoded roles)
✅ Automatic Role Assignment
✅ Custom 403 Error Page

## 🎨 Features

✅ Dynamic Navigation Menu (based on permissions)
✅ User Management Interface
✅ Role Assignment System
✅ Permission Display
✅ Responsive Design (Tailwind CSS)
✅ Dark Mode Support

## 📝 Common Tasks

### Assign Role to User
```php
$user->assignRole('Admin');
```

### Remove Role from User
```php
$user->removeRole('Admin');
```

### Sync Roles (replace all roles)
```php
$user->syncRoles(['Admin', 'Bendahara']);
```

### Check User Permissions
```php
$permissions = $user->getAllPermissions();
```

### Give Direct Permission
```php
$user->givePermissionTo('view reports');
```

## 🧪 Testing

### Test Role Assignment
1. Register new user
2. Check if "Viewer" role is assigned automatically
3. Login as Super Admin
4. Navigate to User Management
5. Assign different roles
6. Verify menu changes based on role

### Test Permission Protection
1. Login as "Viewer"
2. Try accessing `/admin/users` (should get 403)
3. Login as "Super Admin"
4. Access should be granted

## 🔄 Maintenance

### Clear Permission Cache
```bash
php artisan permission:cache-reset
```

### Re-run Seeder (Idempotent)
```bash
php artisan db:seed --class=RolePermissionSeeder
```

## 📊 Database Tables

- `users` - User accounts
- `roles` - Available roles
- `permissions` - Available permissions
- `model_has_roles` - User-Role assignments
- `model_has_permissions` - Direct user permissions
- `role_has_permissions` - Role-Permission assignments

## 🎯 Next Steps

1. Implement transaction management with permission checks
2. Create account management module
3. Build budget tracking system
4. Develop goal management features
5. Generate financial reports
6. Add audit logging

## 📞 Support

For issues or questions, refer to:
- [Laravel Documentation](https://laravel.com/docs)
- [Spatie Permission Documentation](https://spatie.be/docs/laravel-permission)
- [Laravel Breeze Documentation](https://laravel.com/docs/starter-kits#breeze)

---

**System Status:** ✅ Production Ready
**Last Updated:** 2026-02-19
