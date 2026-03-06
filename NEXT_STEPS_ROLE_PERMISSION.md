# Next Steps: Role Permission Implementation

## ✅ Yang Sudah Selesai (Phase 1A)

### 1. Permissions Setup
- ✅ All permissions created (transactions, accounts, categories, budgets, goals, calendar, reports, users)
- ✅ 4 Roles configured: Super Admin, Admin, Bendahara, Viewer
- ✅ Permission matrix defined and seeded

### 2. Test Users Created
- ✅ **Super Admin:** superadmin@basmallah.com / password
- ✅ **Admin:** admin@basmallah.com / password
- ✅ **Bendahara:** bendahara@basmallah.com / password
- ✅ **Viewer:** viewer@basmallah.com / password

### 3. Sidebar Menu Protection
- ✅ All menu items wrapped with `@can()` directives
- ✅ Menu visibility based on user permissions
- ✅ Different menus for different roles

---

## 🎯 Yang Masih Perlu Dikerjakan (Phase 1B)

### Priority 1: Route Protection ⚠️ (CRITICAL)

**Status:** Not Started

**Problem:**
- Users can bypass UI by accessing URLs directly
- Example: Viewer can access `/transactions` via URL even though menu is hidden
- Security hole: No server-side protection

**Solution:**
Add permission middleware to all routes in `routes/web.php`

**Example:**
```php
// Transactions Routes
Route::middleware(['auth', 'permission:view transactions'])
    ->get('/transactions', [TransactionController::class, 'index'])
    ->name('transactions.index');

Route::middleware(['auth', 'permission:create transactions'])
    ->get('/transactions/create', [TransactionController::class, 'create'])
    ->name('transactions.create');

Route::middleware(['auth', 'permission:edit transactions'])
    ->get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])
    ->name('transactions.edit');

Route::middleware(['auth', 'permission:delete transactions'])
    ->delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])
    ->name('transactions.destroy');
```

**Files to Update:**
- `routes/web.php` (main file)

**Estimated Time:** 1-2 hours

**Impact:** HIGH - Prevents unauthorized access via URL

---

### Priority 2: Controller Authorization ⚠️ (HIGH)

**Status:** Not Started

**Problem:**
- Controllers don't check permissions
- Users can manipulate forms/API to perform unauthorized actions
- Example: Bendahara can delete transactions via form manipulation

**Solution:**
Add authorization checks in controller methods

**Example:**
```php
// TransactionController.php
public function create()
{
    $this->authorize('create', Transaction::class);
    // ... rest of code
}

public function edit(Transaction $transaction)
{
    $this->authorize('update', $transaction);
    // ... rest of code
}

public function destroy(Transaction $transaction)
{
    $this->authorize('delete', $transaction);
    // ... rest of code
}
```

**Files to Update:**
- `app/Http/Controllers/TransactionController.php`
- `app/Http/Controllers/AccountController.php`
- `app/Http/Controllers/CategoryController.php`
- `app/Http/Controllers/BudgetController.php`
- `app/Http/Controllers/GoalController.php`
- `app/Http/Controllers/CalendarController.php`
- `app/Http/Controllers/ReportController.php`
- `app/Http/Controllers/Admin/UserController.php`

**Estimated Time:** 2-3 hours

**Impact:** HIGH - Prevents unauthorized actions

---

### Priority 3: Create Policies (HIGH)

**Status:** Not Started

**Problem:**
- No policies defined for authorization
- Controllers can't use `$this->authorize()`

**Solution:**
Create policy classes for each model

**Example:**
```php
// app/Policies/TransactionPolicy.php
class TransactionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view transactions');
    }

    public function create(User $user): bool
    {
        return $user->can('create transactions');
    }

    public function update(User $user, Transaction $transaction): bool
    {
        return $user->can('edit transactions');
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->can('delete transactions');
    }
}
```

**Files to Create:**
- `app/Policies/TransactionPolicy.php`
- `app/Policies/AccountPolicy.php`
- `app/Policies/CategoryPolicy.php`
- `app/Policies/BudgetPolicy.php`
- `app/Policies/GoalPolicy.php`

**Register in:** `app/Providers/AuthServiceProvider.php`

**Estimated Time:** 1-2 hours

**Impact:** HIGH - Required for controller authorization

---

### Priority 4: UI Button Protection (MEDIUM)

**Status:** Not Started

**Problem:**
- Edit/Delete buttons visible to all users
- Confusing UX (users see buttons they can't use)
- Users might try to click and get errors

**Solution:**
Wrap buttons with `@can()` directives

**Example:**
```blade
<!-- Transaction Index -->
@can('edit transactions')
    <a href="{{ route('transactions.edit', $transaction) }}">Edit</a>
@endcan

@can('delete transactions')
    <form method="POST" action="{{ route('transactions.destroy', $transaction) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
@endcan
```

**Files to Update:**
- `resources/views/transactions/index.blade.php`
- `resources/views/transactions/show.blade.php`
- `resources/views/accounts/index.blade.php`
- `resources/views/accounts/show.blade.php`
- `resources/views/categories/index.blade.php`
- `resources/views/budgets/index.blade.php`
- `resources/views/goals/index.blade.php`
- All other CRUD views

**Estimated Time:** 2-3 hours

**Impact:** MEDIUM - Better UX, prevents confusion

---

## 🚨 Current Security Risks

### Risk Level: HIGH ⚠️

**What's Protected:**
- ✅ Sidebar menu (UI only)

**What's NOT Protected:**
- ❌ Routes (can bypass via URL)
- ❌ Controllers (can bypass via form manipulation)
- ❌ API endpoints (if any)

**Example Attack Scenarios:**

1. **Viewer bypasses UI:**
   - Menu "Transaksi" hidden
   - But can access `/transactions` directly via URL
   - Can see all transactions!

2. **Bendahara deletes transaction:**
   - No "Delete" button in UI
   - But can submit DELETE request via browser console
   - Transaction deleted!

3. **Admin creates user:**
   - No "Pengguna" menu
   - But can access `/admin/users/create` via URL
   - Can create users!

**Conclusion:** Sidebar protection alone is NOT enough!

---

## 📋 Recommended Implementation Order

### Phase 1B: Complete Role Permission (Recommended)

**Step 1: Route Protection** (1-2 hours)
- Add middleware to all routes
- Test unauthorized access returns 403
- **Benefit:** Prevents URL bypass

**Step 2: Create Policies** (1-2 hours)
- Create policy classes
- Register in AuthServiceProvider
- **Benefit:** Foundation for controller auth

**Step 3: Controller Authorization** (2-3 hours)
- Add `$this->authorize()` in controllers
- Test unauthorized actions blocked
- **Benefit:** Prevents form manipulation

**Step 4: UI Button Protection** (2-3 hours)
- Hide buttons based on permission
- Test UI shows correct buttons
- **Benefit:** Better UX

**Total Time:** 6-10 hours
**Total Progress:** 100% Role Permission Complete

---

### Alternative: Skip to Multi-Tenancy (Not Recommended)

**Pros:**
- Faster to see multi-tenant features
- More exciting functionality

**Cons:**
- Security holes remain
- Must come back to fix later
- Harder to debug with multi-tenancy + broken permissions
- Technical debt accumulates

**Recommendation:** Complete Phase 1B first, then multi-tenancy.

---

## 🧪 Testing Checklist

### After Route Protection:
- [ ] Super Admin can access all routes
- [ ] Admin cannot access `/admin/users`
- [ ] Bendahara cannot access `/categories`
- [ ] Viewer cannot access `/transactions`
- [ ] Unauthorized access returns 403 error

### After Controller Authorization:
- [ ] Bendahara cannot delete transactions
- [ ] Viewer cannot create transactions
- [ ] Admin cannot manage users
- [ ] All CRUD operations check permissions

### After UI Button Protection:
- [ ] Bendahara doesn't see "Delete" button
- [ ] Viewer doesn't see "Edit" button
- [ ] Admin doesn't see "Manage Users" button
- [ ] Super Admin sees all buttons

---

## 💡 Quick Commands

```bash
# Create policies
php artisan make:policy TransactionPolicy --model=Transaction
php artisan make:policy AccountPolicy --model=Account
php artisan make:policy CategoryPolicy --model=Category

# Clear cache after changes
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Test with different users
# Login as: superadmin@basmallah.com
# Login as: admin@basmallah.com
# Login as: bendahara@basmallah.com
# Login as: viewer@basmallah.com
```

---

## 🎯 Definition of Done

Phase 1B is complete when:

- [ ] All routes protected with middleware
- [ ] All policies created and registered
- [ ] All controllers check authorization
- [ ] All UI buttons hidden based on permission
- [ ] All 4 roles tested thoroughly
- [ ] No way to bypass permission checks
- [ ] 403 errors shown for unauthorized access
- [ ] Documentation updated

**Current Progress: 30%**
**After Phase 1B: 100%**

---

## 🚀 After Phase 1B Complete

Then we can safely move to:

### Phase 2: Multi-Tenancy
- Create Masjid model
- Add masjid_id to all tables
- Implement tenant scoping
- Super Admin can switch masjid
- Data isolation per masjid

**Estimated Time:** 8-12 hours

---

## 📞 Need Help?

If you encounter issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check permission cache: `php artisan permission:cache-reset`
3. Verify user has correct role: Check `model_has_roles` table
4. Test in incognito mode (clear session)

---

## ✅ Summary

**Completed:**
- Sidebar menu protection (UI only)
- Test users created
- Permissions seeded

**Next Priority:**
- Route protection (CRITICAL)
- Controller authorization (HIGH)
- UI button protection (MEDIUM)

**Recommendation:**
Complete Phase 1B before moving to multi-tenancy for security and stability.

---

**Last Updated:** 2026-02-28
**Status:** Phase 1A Complete, Phase 1B Pending
