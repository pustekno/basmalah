# Multi-Masjid Testing Guide

## Status: Step 6 - Testing & Verification

Panduan ini menjelaskan cara menguji implementasi Multi-Masjid (Multi-Tenancy) yang telah selesai.

---

## ✅ Completed Steps

### Step 1: Database Structure ✓
- Tabel `masjids` dibuat
- Kolom `masjid_id` ditambahkan ke semua tabel (users, accounts, transactions, categories, budgets, goals, deposits)

### Step 2: Global Scope & Model Updates ✓
- `MasjidScope` dibuat untuk auto-filter data berdasarkan masjid
- Semua model diupdate dengan scope dan relationship

### Step 3: Masjid Switcher ✓
- `MasjidController` dibuat dengan method `switch()` dan `clearSwitch()`
- UI dropdown ditambahkan di sidebar untuk Super Admin

### Step 4: Seeder ✓
- 3 masjid dibuat (Al-Ikhlas, An-Nur, At-Taqwa)
- User test di-assign ke masjid masing-masing

### Step 5: Update Controllers ✓
- Semua controller/service diupdate untuk auto-assign `masjid_id`

---

## 🧪 Testing Scenarios

### Test 1: Super Admin - View All Data
**Login sebagai:** superadmin@basmallah.com / password

**Expected Behavior:**
1. Dropdown masjid switcher muncul di sidebar
2. Default menampilkan "All Masjids"
3. Dapat melihat data dari semua masjid (accounts, transactions, categories, dll)
4. Total di dashboard menampilkan gabungan dari semua masjid

**Test Steps:**
```bash
# 1. Login sebagai Super Admin
# 2. Buka Dashboard - lihat total balance dari semua masjid
# 3. Buka Accounts - lihat semua akun dari semua masjid
# 4. Buka Transactions - lihat semua transaksi dari semua masjid
# 5. Buka Categories, Budgets, Goals - lihat semua data
```

---

### Test 2: Super Admin - Switch to Specific Masjid
**Login sebagai:** superadmin@basmallah.com / password

**Expected Behavior:**
1. Klik dropdown masjid switcher
2. Pilih "Masjid Al-Ikhlas"
3. Data yang ditampilkan hanya dari Masjid Al-Ikhlas
4. Dropdown menampilkan "Masjid Al-Ikhlas" sebagai active

**Test Steps:**
```bash
# 1. Login sebagai Super Admin
# 2. Klik dropdown masjid switcher
# 3. Pilih "Masjid Al-Ikhlas"
# 4. Buka Dashboard - lihat hanya data Masjid Al-Ikhlas
# 5. Buka Accounts - lihat hanya akun Masjid Al-Ikhlas
# 6. Buka Transactions - lihat hanya transaksi Masjid Al-Ikhlas
```

---

### Test 3: Super Admin - Create Data for Specific Masjid
**Login sebagai:** superadmin@basmallah.com / password

**Expected Behavior:**
1. Switch ke "Masjid An-Nur"
2. Buat account baru
3. Account tersebut otomatis ter-assign ke Masjid An-Nur
4. Hanya user dari Masjid An-Nur yang bisa melihat account tersebut

**Test Steps:**
```bash
# 1. Login sebagai Super Admin
# 2. Switch ke "Masjid An-Nur"
# 3. Buka Accounts > Create New Account
# 4. Isi form: Name="Kas An-Nur", Type="cash", Balance=1000000
# 5. Submit
# 6. Verify: Account muncul di list
# 7. Switch ke "Masjid Al-Ikhlas"
# 8. Verify: Account "Kas An-Nur" TIDAK muncul di list
```

---

### Test 4: Admin - View Only Their Masjid Data
**Login sebagai:** admin@basmallah.com / password (Masjid Al-Ikhlas)

**Expected Behavior:**
1. TIDAK ada dropdown masjid switcher
2. Hanya melihat data dari Masjid Al-Ikhlas
3. Tidak bisa melihat data dari masjid lain

**Test Steps:**
```bash
# 1. Login sebagai admin@basmallah.com
# 2. Verify: Dropdown masjid switcher TIDAK muncul
# 3. Buka Dashboard - lihat hanya data Masjid Al-Ikhlas
# 4. Buka Accounts - lihat hanya akun Masjid Al-Ikhlas
# 5. Buka Transactions - lihat hanya transaksi Masjid Al-Ikhlas
```

---

### Test 5: Admin - Create Data (Auto-assign to Their Masjid)
**Login sebagai:** admin@basmallah.com / password (Masjid Al-Ikhlas)

**Expected Behavior:**
1. Buat account/transaction/category baru
2. Data otomatis ter-assign ke Masjid Al-Ikhlas
3. Admin dari masjid lain tidak bisa melihat data tersebut

**Test Steps:**
```bash
# 1. Login sebagai admin@basmallah.com
# 2. Buka Categories > Create New Category
# 3. Isi form: Name="Infaq Jumat", Type="income"
# 4. Submit
# 5. Verify: Category muncul di list
# 6. Logout
# 7. Login sebagai admin.annur@basmallah.com (Masjid An-Nur)
# 8. Buka Categories
# 9. Verify: Category "Infaq Jumat" TIDAK muncul di list
```

---

### Test 6: Bendahara - Limited Access
**Login sebagai:** bendahara@basmallah.com / password (Masjid An-Nur)

**Expected Behavior:**
1. TIDAK ada dropdown masjid switcher
2. Hanya melihat data dari Masjid An-Nur
3. Hanya bisa create/edit transactions, view accounts, view reports
4. TIDAK bisa manage accounts, categories, budgets, goals

**Test Steps:**
```bash
# 1. Login sebagai bendahara@basmallah.com
# 2. Verify: Dropdown masjid switcher TIDAK muncul
# 3. Verify: Menu Categories, Budgets, Goals TIDAK muncul di sidebar
# 4. Buka Transactions - lihat hanya transaksi Masjid An-Nur
# 5. Buka Accounts - lihat hanya akun Masjid An-Nur (read-only)
# 6. Try create new account - should get 403 Forbidden
```

---

### Test 7: Viewer - Read-Only Access
**Login sebagai:** viewer@basmallah.com / password (Masjid At-Taqwa)

**Expected Behavior:**
1. TIDAK ada dropdown masjid switcher
2. Hanya melihat data dari Masjid At-Taqwa
3. Hanya bisa view reports
4. TIDAK bisa create/edit/delete apapun

**Test Steps:**
```bash
# 1. Login sebagai viewer@basmallah.com
# 2. Verify: Dropdown masjid switcher TIDAK muncul
# 3. Verify: Hanya menu Dashboard dan Reports yang muncul
# 4. Buka Reports - lihat hanya data Masjid At-Taqwa
# 5. Try access /accounts - should get 403 Forbidden
# 6. Try access /transactions - should get 403 Forbidden
```

---

### Test 8: Data Isolation Between Masjids
**Test cross-masjid data isolation**

**Expected Behavior:**
1. Data dari satu masjid tidak bisa diakses oleh user dari masjid lain
2. Super Admin bisa switch dan melihat semua data

**Test Steps:**
```bash
# 1. Login sebagai admin@basmallah.com (Masjid Al-Ikhlas)
# 2. Buat account: "Kas Masjid Al-Ikhlas"
# 3. Buat transaction: Income 500000 ke account tersebut
# 4. Logout
# 5. Login sebagai admin.annur@basmallah.com (Masjid An-Nur)
# 6. Verify: Account "Kas Masjid Al-Ikhlas" TIDAK muncul
# 7. Verify: Transaction 500000 TIDAK muncul
# 8. Logout
# 9. Login sebagai superadmin@basmallah.com
# 10. View All Masjids
# 11. Verify: Bisa melihat account dan transaction dari semua masjid
```

---

## 🔍 Database Verification

Untuk memverifikasi data di database:

```sql
-- Check masjids
SELECT * FROM masjids;

-- Check users with their masjid
SELECT id, name, email, masjid_id FROM users;

-- Check accounts with masjid_id
SELECT id, name, type, masjid_id FROM accounts;

-- Check transactions with masjid_id
SELECT id, type, amount, masjid_id FROM transactions LIMIT 10;

-- Check categories with masjid_id
SELECT id, name, type, masjid_id FROM categories;

-- Check budgets with masjid_id
SELECT id, name, amount, masjid_id FROM budgets;

-- Check goals with masjid_id
SELECT id, name, target_amount, masjid_id FROM goals;
```

---

## ✅ Expected Results

### Database Structure
- ✓ Tabel `masjids` ada dengan 3 records
- ✓ Semua tabel memiliki kolom `masjid_id`
- ✓ Super Admin memiliki `masjid_id = NULL`
- ✓ User lain memiliki `masjid_id` yang valid

### User Roles & Permissions
- ✓ Super Admin: Bisa switch masjid dan melihat semua data
- ✓ Admin: Hanya melihat data masjid mereka, full CRUD access
- ✓ Bendahara: Hanya melihat data masjid mereka, limited access
- ✓ Viewer: Hanya melihat data masjid mereka, read-only

### Data Isolation
- ✓ User tidak bisa melihat data dari masjid lain
- ✓ Data baru otomatis ter-assign ke masjid yang sesuai
- ✓ Super Admin bisa melihat semua data atau filter by masjid

---

## 🐛 Common Issues & Solutions

### Issue 1: Super Admin tidak bisa create data
**Problem:** Super Admin tidak memilih masjid, sehingga `masjid_id = NULL`

**Solution:** Super Admin harus switch ke masjid tertentu sebelum create data

### Issue 2: User melihat data dari masjid lain
**Problem:** `MasjidScope` tidak berjalan dengan benar

**Solution:** 
- Check apakah model sudah menggunakan `#[ScopedBy([MasjidScope::class])]`
- Check apakah `masjid_id` sudah ada di tabel

### Issue 3: Error saat create data
**Problem:** `masjid_id` tidak ter-assign

**Solution:**
- Check method `getMasjidId()` di controller/service
- Pastikan Super Admin sudah switch ke masjid tertentu

---

## 📝 Test Accounts

| Email | Password | Role | Masjid | Access Level |
|-------|----------|------|--------|--------------|
| superadmin@basmallah.com | password | Super Admin | All | Full access, can switch |
| admin@basmallah.com | password | Admin | Al-Ikhlas | Full CRUD for their masjid |
| admin.annur@basmallah.com | password | Admin | An-Nur | Full CRUD for their masjid |
| admin.attaqwa@basmallah.com | password | Admin | At-Taqwa | Full CRUD for their masjid |
| bendahara@basmallah.com | password | Bendahara | An-Nur | Limited access |
| viewer@basmallah.com | password | Viewer | At-Taqwa | Read-only |

---

## 🎯 Next Steps

Setelah testing selesai dan semua berjalan dengan baik:

1. ✅ **Phase 2 Complete** - Multi-Masjid implementation done
2. 📋 **Documentation** - Update user manual dengan fitur multi-masjid
3. 🚀 **Production** - Deploy ke production server
4. 📊 **Monitoring** - Monitor performance dan data isolation

---

## 📞 Support

Jika menemukan bug atau issue:
1. Catat langkah-langkah untuk reproduce issue
2. Screenshot error message
3. Check database untuk verify data
4. Report ke developer

---

**Last Updated:** March 4, 2026
**Status:** Ready for Testing
