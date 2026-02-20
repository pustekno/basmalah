# Dokumentasi Fitur Goals/Target & Laporan (Reports) - LIGA

## Overview

Sistem monitoring dan visualisasi data untuk tracking target dana (Goals) dan laporan analisis pencapaian target. Bagian ini fokus pada fitur monitoring dan visualisasi, bukan pada manajemen transaksi.

## Pembagian Tugas Tim

**LIGA (Monitoring & Visualisasi):**

- ✅ Goals/Target - tracking progress pencapaian target dana
- ✅ Laporan (Reports) - analisis dan visualisasi data target

**BAGUS (Core Transaction Layer):**

- Manajemen Transaksi Keuangan
- Manajemen Akun/Kas
- Kalender

**AZRIL (Klasifikasi & Perencanaan):**

- Kategori & Sub-Kategori
- Budgeting

**YOLA (Infrastruktur Sistem):**

- Multi-user & Role Management
- Multi-language

## Fitur yang Telah Diimplementasikan (LIGA)

### 1. Goals & Targets (Monitoring Target Dana)

#### Fitur Utama:

- **CRUD Goals/Targets**
    - Buat target dana baru dengan judul, deskripsi, target amount, periode, dan kategori
    - Edit dan update target yang sudah ada (termasuk current_amount manual)
    - Hapus target
    - Lihat detail target dengan progress tracking

- **Progress Monitoring**
    - Progress bar visual menampilkan persentase pencapaian
    - Tracking dana terkumpul vs target dana
    - Kalkulasi otomatis sisa target
    - Status target: Active, Completed, Cancelled
    - Update manual current_amount (akan diintegrasikan dengan transaksi oleh BAGUS)

#### Halaman:

- `/goals` - Daftar semua target dengan progress bar
- `/goals/create` - Form buat target baru
- `/goals/{id}` - Detail target dengan statistik
- `/goals/{id}/edit` - Form edit target (termasuk current_amount)

### 2. Reports (Laporan & Analisis Target)

#### A. Dashboard Reports (`/reports`)

**Fitur:**

- Quick access ke laporan target
- Ringkasan cepat:
    - Target aktif
    - Target selesai
    - Total target

#### B. Laporan Target (`/reports/goals`)

**Fitur:**

- **Statistik Keseluruhan**
    - Total target
    - Target aktif
    - Target selesai
    - Total target dana
    - Total dana terkumpul

- **Progress Keseluruhan**
    - Progress bar gabungan semua target aktif
    - Persentase pencapaian total

- **Filter Status**
    - Semua status
    - Aktif
    - Selesai
    - Dibatalkan

- **Detail per Target**
    - Card untuk setiap target dengan:
        - Target dana
        - Dana terkumpul
        - Sisa target
        - Progress percentage
        - Progress bar visual
        - Periode
        - Kategori

## Database Schema

### Table: goals

```sql
- id (bigint, primary key)
- title (string)
- description (text, nullable)
- target_amount (decimal 15,2)
- current_amount (decimal 15,2, default 0)
- start_date (date)
- end_date (date)
- status (enum: active, completed, cancelled)
- category (string, nullable)
- created_by (foreign key -> users.id)
- timestamps
```

**Note:** Table `transactions` akan dibuat oleh BAGUS dan akan memiliki relasi ke `goals.id`

## Models & Relationships

### Goal Model

```php
// Relationships
- creator() -> BelongsTo User
// transactions() -> HasMany Transaction (akan ditambahkan oleh BAGUS)

// Attributes
- progress_percentage (computed)
- remaining_amount (computed)

// Fillable
- title, description, target_amount, current_amount
- start_date, end_date, status, category, created_by
```

## Controllers

### GoalController

- `index()` - List goals dengan pagination
- `create()` - Form buat goal
- `store()` - Simpan goal baru
- `show()` - Detail goal
- `edit()` - Form edit goal (termasuk current_amount)
- `update()` - Update goal
- `destroy()` - Hapus goal

### ReportController

- `index()` - Dashboard reports
- `goals()` - Laporan target dengan monitoring
- `export()` - Export data (placeholder untuk future)

## Routes

```php
// Goals & Targets - accessible by authenticated users
Route::middleware(['auth'])->group(function () {
    Route::resource('goals', GoalController::class);
});

// Reports (dengan permission)
Route::middleware(['auth', 'permission:view reports'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/reports/goals', [ReportController::class, 'goals']);
    Route::post('/reports/export', [ReportController::class, 'export']);
});
```

## Permissions Required

Untuk menggunakan fitur ini:

- `view reports` - Untuk akses halaman reports
- Goals dapat diakses oleh semua authenticated users

## Cara Penggunaan

### 1. Membuat Target Baru

1. Klik menu "Goals & Targets"
2. Klik tombol "Tambah Target Baru"
3. Isi form:
    - Judul target
    - Deskripsi (opsional)
    - Target dana (Rp)
    - Kategori (opsional)
    - Tanggal mulai dan selesai
4. Klik "Simpan Target"

### 2. Update Progress Target (Manual)

1. Buka detail target
2. Klik "Edit"
3. Update field "Dana Terkumpul"
4. Update status jika perlu
5. Klik "Update Target"

**Note:** Nantinya current_amount akan otomatis terupdate ketika BAGUS mengimplementasikan transaksi yang terhubung ke goal.

### 3. Monitoring Target

1. Klik menu "Reports"
2. Pilih "Laporan Target"
3. Filter berdasarkan status (opsional)
4. Lihat:
    - Statistik keseluruhan
    - Progress total
    - Detail per target

## Visualisasi Data

### Progress Bars

- Menggunakan Tailwind CSS untuk styling
- Warna dinamis berdasarkan status:
    - Hijau: Active goals
    - Biru: Completed goals
    - Abu-abu: Cancelled goals
- Animasi smooth dengan transition
- Gradient untuk progress keseluruhan

### Cards & Statistics

- Summary cards dengan warna berbeda
- Icon SVG untuk visual appeal
- Responsive design untuk mobile
- Grid layout yang fleksibel

## Sample Data

Untuk testing, jalankan seeder:

```bash
php artisan db:seed --class=GoalTransactionSeeder
```

Ini akan membuat 4 goals dengan berbagai status dan progress.

## Integrasi dengan Fitur Lain

### Dengan BAGUS (Transaksi):

- Goals memiliki field untuk link ke transaksi (goal_id di table transactions)
- Current_amount akan otomatis terupdate ketika ada transaksi baru
- Auto-complete goal ketika target tercapai

### Dengan AZRIL (Kategori):

- Field category di goals bisa menggunakan kategori yang dibuat AZRIL
- Laporan bisa difilter berdasarkan kategori

### Dengan YOLA (Multi-user):

- Goals tracking siapa yang membuat (created_by)
- Permission-based access untuk reports

## Future Enhancements

Fitur yang bisa ditambahkan:

1. Export laporan ke PDF/Excel
2. Chart.js untuk visualisasi lebih advanced
3. Dashboard widgets untuk homepage
4. Email notifications untuk milestone
5. Timeline view untuk goals
6. Comparison charts antar goals
7. Forecast & predictions
8. Goal templates
9. Recurring goals
10. Goal categories management

## Technical Notes

- Menggunakan Laravel 12
- Eloquent relationships untuk efficient queries
- Blade components untuk reusable UI
- Tailwind CSS untuk styling
- Alpine.js untuk interactivity (dari Breeze)
- Permission-based access control (Spatie)
- Computed attributes untuk progress calculation

## API untuk Integrasi

### Goal Model Methods

```php
// Untuk digunakan oleh BAGUS saat membuat transaksi
$goal->increment('current_amount', $amount);
$goal->decrement('current_amount', $amount);

// Check progress
$goal->progress_percentage; // Returns float 0-100
$goal->remaining_amount; // Returns decimal

// Auto-complete check
if ($goal->current_amount >= $goal->target_amount) {
    $goal->update(['status' => 'completed']);
}
```

## Troubleshooting

### Error: Permission denied untuk reports

- Pastikan user memiliki permission `view reports`
- Jalankan: `php artisan permission:cache-reset`

### Progress tidak tampil dengan benar

- Check bahwa target_amount tidak 0
- Pastikan current_amount dan target_amount adalah decimal
- Check computed attribute di Goal model

### Laporan kosong

- Pastikan ada data goals
- Check filter status
- Jalankan seeder untuk sample data

## Testing

Untuk testing fitur ini:

1. Login sebagai Super Admin
2. Buat beberapa goals dengan status berbeda
3. Update current_amount secara manual
4. Lihat progress di halaman goals
5. Check laporan di menu Reports

## Support

Untuk pertanyaan atau issue terkait fitur Goals & Reports (LIGA), hubungi tim LIGA.

---

**Catatan Penting:**

- Fitur ini adalah bagian LIGA (Monitoring & Visualisasi)
- Transaksi keuangan adalah bagian BAGUS
- Integrasi penuh akan terjadi setelah BAGUS selesai implementasi transaksi
- Current_amount saat ini diupdate manual, nantinya otomatis via transaksi
