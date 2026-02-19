# 🔐 Kredensial Login - Masjid Basmallah

## 👥 Akun Testing

### 1️⃣ Super Admin
```
Email: admin@masjid.com
Password: password123
Role: Super Admin
```
**Akses:**
- ✅ Semua fitur
- ✅ Manage users
- ✅ Manage transactions
- ✅ Manage accounts
- ✅ Manage budgets
- ✅ Manage goals
- ✅ View reports

---

### 2️⃣ Admin
```
Email: admin@masjid.com
Password: admin123
Role: Admin
```
**Akses:**
- ✅ Manage transactions (CRUD)
- ✅ Manage accounts
- ✅ Manage budgets
- ✅ Manage goals
- ✅ View reports
- ❌ Manage users (tidak bisa)

---

### 3️⃣ Bendahara
```
Email: bendahara@masjid.com
Password: bendahara123
Role: Bendahara
```
**Akses:**
- ✅ Create transactions
- ✅ Edit transactions
- ✅ View accounts
- ✅ View reports
- ❌ Delete transactions
- ❌ Manage accounts
- ❌ Manage budgets
- ❌ Manage users

---

## 🚀 Cara Login

1. Buka: `http://localhost:8000/login`
2. Masukkan email dan password sesuai role yang ingin dicoba
3. Klik "Masuk"
4. Lihat perbedaan menu dan akses berdasarkan role

---

## 🧪 Testing Skenario

### Test 1: Super Admin
1. Login sebagai Super Admin
2. Akses `/admin/users` ✅ Berhasil
3. Lihat menu lengkap di navigation

### Test 2: Admin
1. Login sebagai Admin
2. Akses `/admin/dashboard` ✅ Berhasil
3. Akses `/admin/users` ❌ Forbidden (403)
4. Menu "Users" tidak muncul

### Test 3: Bendahara
1. Login sebagai Bendahara
2. Akses `/admin/dashboard` ❌ Forbidden (403)
3. Hanya bisa akses fitur transaksi dan reports
4. Menu terbatas sesuai permission

---

## 📝 Catatan

- Password bisa diganti sesuai kebutuhan
- Untuk production, gunakan password yang lebih kuat
- Super Admin adalah user pertama yang dibuat
- Role dapat diubah melalui User Management (Super Admin only)

---

## 🔄 Reset Password (via Tinker)

```bash
php artisan tinker
```

```php
$user = App\Models\User::where('email', 'admin@masjid.com')->first();
$user->password = bcrypt('password_baru');
$user->save();
```

---

## ➕ Tambah User Baru (via Tinker)

```bash
php artisan tinker
```

```php
$user = App\Models\User::create([
    'name' => 'Nama User',
    'email' => 'email@example.com',
    'password' => bcrypt('password123')
]);
$user->assignRole('Viewer'); // atau 'Admin', 'Bendahara', 'Super Admin'
```

---

**Status:** ✅ Semua akun siap digunakan  
**Total Users:** 3 (Super Admin, Admin, Bendahara)  
**Last Updated:** 2026-02-19
