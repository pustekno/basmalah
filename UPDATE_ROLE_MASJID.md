# Update Role Permission & Multi-Masjid

## Perintah Setelah Pull

```bash
# 1. Pull perubahan
git pull origin main

# 2. Install package baru (spatie/laravel-permission)
composer install

# 3. Refresh autoload
composer dump-autoload

# 4. Jalankan migrasi baru (untuk tabel masjid & permissions)
php artisan migrate:fresh --seed

# 5. Clear cache
php artisan config:clear
php artisan cache:clear
```

---

## ⚠️ PENTING: Urutan Migrasi

Pastikan file migrasi `create_masjids_table` ada dengan timestamp `2026_03_03_065257` (SEBELUM migrasi add_masjid_id).

Jika tidak ada, file ini sudah di-commit dan akan otomatis ter-pull.

---

## Test Users Baru

| Email | Password | Role | Masjid |
|-------|----------|------|--------|
| superadmin@basmallah.com | password | Super Admin | All (bisa switch) |
| admin@basmallah.com | password | Admin | Al-Ikhlas |
| bendahara@basmallah.com | password | Bendahara | An-Nur |
| viewer@basmallah.com | password | Viewer | All (bisa switch) |

---

## Fitur Baru

✅ **Role & Permission System**
- 4 roles: Super Admin, Admin, Bendahara, Viewer
- Permission-based access control

✅ **Multi-Masjid (Multi-Tenancy)**
- 3 masjid: Al-Ikhlas, An-Nur, At-Taqwa
- Data ter-filter per masjid
- Super Admin & Viewer bisa switch masjid

---

## Troubleshooting

Jika ada error:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```
