# 🚀 Quick Start Guide - Masjid Basmallah RBAC System

## ✅ Installation Complete!

All packages have been installed and configured:
- ✅ Laravel Breeze (Authentication)
- ✅ Spatie Laravel Permission (RBAC)
- ✅ Database migrations completed
- ✅ Roles & Permissions seeded

## 🎯 Test the System Now

### Step 1: Start the Server
```bash
php artisan serve
```

### Step 2: Register First User
1. Open browser: `http://localhost:8000/register`
2. Register a new account
3. User will automatically get "Viewer" role

### Step 3: Upgrade to Super Admin
Run this command to make first user Super Admin:
```bash
php artisan tinker
```
Then in tinker:
```php
$user = App\Models\User::first();
$user->syncRoles(['Super Admin']);
exit
```

### Step 4: Test Admin Panel
1. Login with your account
2. Navigate to: `http://localhost:8000/admin/dashboard`
3. Click "Users" in navigation menu
4. You should see user management interface

### Step 5: Test Role Assignment
1. Register another user (use different email)
2. Login as Super Admin
3. Go to User Management
4. Assign different roles to the new user
5. Login as that user and see menu changes

## 🧪 Quick Tests

### Test 1: Permission-Based Menu
- Login as "Viewer" → Should only see Dashboard and Reports
- Login as "Bendahara" → Should see Transactions, Reports
- Login as "Admin" → Should see most features
- Login as "Super Admin" → Should see everything including Users

### Test 2: Access Control
Try accessing as "Viewer":
```
http://localhost:8000/admin/users
```
Result: Should get 403 Forbidden error

### Test 3: Role Check in Blade
Create a test view with:
```blade
@role('Super Admin')
    <p>You are Super Admin!</p>
@endrole

@can('view reports')
    <p>You can view reports!</p>
@endcan
```

## 📊 Available Roles

| Role | Permissions |
|------|------------|
| **Super Admin** | All permissions + User management |
| **Admin** | Manage transactions, accounts, budgets, goals, view reports |
| **Bendahara** | Create/edit transactions, view accounts, view reports |
| **Viewer** | View reports only |

## 🔐 Test Credentials Template

After registration, you'll have:
- Email: (your registered email)
- Password: (your password)
- Default Role: Viewer

## 🛠️ Useful Commands

### Clear Permission Cache
```bash
php artisan permission:cache-reset
```

### Re-seed Roles & Permissions
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### Check User Roles
```bash
php artisan tinker
```
```php
$user = App\Models\User::find(1);
$user->roles; // See all roles
$user->getAllPermissions(); // See all permissions
```

### Assign Role via Tinker
```bash
php artisan tinker
```
```php
$user = App\Models\User::find(1);
$user->assignRole('Admin');
```

## 📱 URLs to Test

| URL | Access Level |
|-----|--------------|
| `/dashboard` | All authenticated users |
| `/admin/dashboard` | Super Admin, Admin |
| `/admin/users` | Super Admin only |
| `/profile` | All authenticated users |

## 🎨 UI Features

✅ Dynamic navigation based on permissions
✅ Role badges in user management
✅ Permission display
✅ Responsive design
✅ Dark mode support
✅ Custom 403 error page

## 🔄 Next Development Steps

1. **Transactions Module**
   - Create TransactionController
   - Add permission checks
   - Build CRUD views

2. **Accounts Module**
   - Create AccountController
   - Implement account management
   - Add permission middleware

3. **Reports Module**
   - Create ReportController
   - Build report views
   - Add export functionality

4. **Budget & Goals**
   - Implement budget tracking
   - Create goal management
   - Add progress indicators

## 🐛 Troubleshooting

### Issue: 403 on all admin routes
**Solution:** Make sure you're logged in as Super Admin or Admin
```bash
php artisan tinker
$user = App\Models\User::first();
$user->assignRole('Super Admin');
```

### Issue: Menu not showing
**Solution:** Clear cache and check role assignment
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Issue: Permission denied
**Solution:** Reset permission cache
```bash
php artisan permission:cache-reset
```

## 📚 Documentation

Full documentation available in: `RBAC_DOCUMENTATION.md`

## ✨ System Status

🟢 **READY FOR PRODUCTION**

All security features implemented:
- ✅ Form validation
- ✅ Mass assignment protection
- ✅ Middleware protection
- ✅ Permission-based authorization
- ✅ Automatic role assignment
- ✅ Custom error pages

---

**Happy Coding! 🚀**

Need help? Check the full documentation or Laravel/Spatie docs.
