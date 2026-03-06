# Implementasi Viewer Masjid Switcher

## Status: ✅ SELESAI

## Ringkasan
Viewer (Jemaah) sekarang dapat melihat laporan dari semua masjid dan beralih antara masjid seperti Super Admin.

---

## Perubahan yang Dilakukan

### 1. ✅ MasjidController - Izinkan Viewer Switch Masjid
**File:** `app/Http/Controllers/MasjidController.php`

**Perubahan:**
- Method `switch()`: Ubah dari hanya Super Admin menjadi Super Admin & Viewer
- Method `clearSwitch()`: Ubah dari hanya Super Admin menjadi Super Admin & Viewer

```php
// SEBELUM
if (!auth()->user()->hasRole('Super Admin')) {
    abort(403, 'Unauthorized action.');
}

// SESUDAH
if (!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Viewer')) {
    abort(403, 'Unauthorized action.');
}
```

---

### 2. ✅ Routes - Izinkan Viewer Akses Masjid Switch
**File:** `routes/web.php`

**Perubahan:**
- Update middleware dari `role:Super Admin` menjadi `role:Super Admin|Viewer`

```php
// SEBELUM
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::post('/masjid/switch', [MasjidController::class, 'switch'])->name('masjid.switch');
    Route::post('/masjid/clear', [MasjidController::class, 'clearSwitch'])->name('masjid.clear');
});

// SESUDAH
Route::middleware(['auth', 'role:Super Admin|Viewer'])->group(function () {
    Route::post('/masjid/switch', [MasjidController::class, 'switch'])->name('masjid.switch');
    Route::post('/masjid/clear', [MasjidController::class, 'clearSwitch'])->name('masjid.clear');
});
```

---

### 3. ✅ Sidebar - Tampilkan Masjid Switcher untuk Viewer
**File:** `resources/views/layouts/sidebar.blade.php`

**Perubahan:**
- Update directive dari `@role('Super Admin')` menjadi `@role('Super Admin|Viewer')`

```blade
<!-- SEBELUM -->
@role('Super Admin')
<!-- Masjid Switcher (Super Admin Only) -->

<!-- SESUDAH -->
@role('Super Admin|Viewer')
<!-- Masjid Switcher (Super Admin & Viewer) -->
```

---

### 4. ✅ RolePermissionSeeder - Set Viewer masjid_id ke NULL
**File:** `database/seeders/RolePermissionSeeder.php`

**Perubahan:**
- Viewer tidak lagi terikat ke masjid tertentu (masjid_id = null)
- Tambahkan update untuk memastikan existing viewer juga di-update

```php
// SEBELUM
$viewer = User::firstOrCreate(
    ['email' => 'viewer@basmallah.com'],
    [
        'name' => 'Viewer Masjid At-Taqwa',
        'password' => bcrypt('password'),
        'masjid_id' => $masjid3?->id,
    ]
);

// SESUDAH
$viewer = User::firstOrCreate(
    ['email' => 'viewer@basmallah.com'],
    [
        'name' => 'Viewer Jemaah',
        'password' => bcrypt('password'),
        'masjid_id' => null,
    ]
);
if (!$viewer->hasRole('Viewer')) {
    $viewer->assignRole('Viewer');
}
// Update existing viewer to have null masjid_id
$viewer->update(['masjid_id' => null]);
```

---

## Cara Menjalankan Update

### Opsi 1: Jalankan Seeder (Recommended)
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### Opsi 2: Update Manual via Database
Jika database sudah running, jalankan query ini:
```sql
UPDATE users 
SET masjid_id = NULL, name = 'Viewer Jemaah'
WHERE email = 'viewer@basmallah.com';
```

---

## Testing

### Login sebagai Viewer
- **Email:** viewer@basmallah.com
- **Password:** password

### Fitur yang Harus Ditest:
1. ✅ Viewer dapat melihat dropdown masjid switcher di sidebar
2. ✅ Viewer dapat switch ke masjid tertentu
3. ✅ Viewer dapat clear selection untuk melihat semua masjid
4. ✅ Viewer hanya dapat akses menu Reports (tidak bisa create/edit/delete)
5. ✅ Data yang ditampilkan berubah sesuai masjid yang dipilih

---

## Arsitektur Multi-Tenancy

### Role & Masjid Access Matrix

| Role | Masjid Assignment | Can Switch Masjid | Access Level |
|------|------------------|-------------------|--------------|
| **Super Admin** | None (null) | ✅ Yes | Full access to all features |
| **Admin** | 1 Masjid | ❌ No | Full access to assigned masjid only |
| **Bendahara** | 1 Masjid | ❌ No | Limited access to assigned masjid |
| **Viewer** | None (null) | ✅ Yes | Read-only reports for all/selected masjid |

### Data Filtering Logic (MasjidScope)

```php
// Super Admin & Viewer
if ($user->hasRole('Super Admin') || $user->hasRole('Viewer')) {
    // If active_masjid_id in session, filter by that masjid
    if (session()->has('active_masjid_id')) {
        $builder->where('masjid_id', session('active_masjid_id'));
    }
    // Otherwise, see all data
    return;
}

// Admin & Bendahara
if ($user->masjid_id) {
    $builder->where('masjid_id', $user->masjid_id);
}
```

---

## File yang Dimodifikasi

1. ✅ `app/Http/Controllers/MasjidController.php`
2. ✅ `routes/web.php`
3. ✅ `resources/views/layouts/sidebar.blade.php`
4. ✅ `database/seeders/RolePermissionSeeder.php`

---

## Next Steps (Opsional)

### Peningkatan UI/UX:
1. Tambahkan icon berbeda untuk Viewer vs Super Admin di dropdown
2. Tambahkan tooltip "Pilih masjid untuk melihat laporan"
3. Tambahkan badge "Viewing: [Masjid Name]" di halaman reports

### Peningkatan Fungsionalitas:
1. Simpan preferensi masjid terakhir yang dipilih Viewer
2. Tambahkan filter masjid di halaman reports
3. Export reports dengan informasi masjid yang dipilih

---

## Kesimpulan

✅ **Implementasi Selesai!**

Viewer (Jemaah) sekarang dapat:
- Melihat dropdown masjid switcher di sidebar
- Beralih antara masjid untuk melihat laporan spesifik
- Melihat semua data masjid jika tidak ada masjid yang dipilih
- Tetap dibatasi hanya untuk akses read-only (reports)

**Status Multi-Tenancy:** 100% Complete ✅
