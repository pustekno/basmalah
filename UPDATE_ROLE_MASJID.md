# Update Role Permission & Multi-Masjid

## Perintah Setelah Pull

```bash
# 1. Pull perubahan
git pull origin main

# 2. Install package baru (spatie/laravel-permission)
composer install

# 3. Jalankan migrasi baru (untuk tabel masjid & permissions)
php artisan migrate

# 4. Refresh autoload (penting!)
composer dump-autoload

# 5. Jalankan seeder (otomatis jalankan semua seeder yang diperlukan)
php artisan db:seed

# 6. Clear cache
php artisan config:clear
php artisan cache:clear
```

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
