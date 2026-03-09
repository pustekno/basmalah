ebelum mulai, saya mau konfirmasi dulu requirement-nya berdasarkan diskusi sebelumnya:

Requirement Multi-Masjid (Konfirmasi):
3 Masjid akan ada di sistem
1 User = 1 Role di 1 Masjid (tidak bisa multiple masjid per user, kecuali Super Admin)
Super Admin bisa switch antara masjid (lihat semua data semua masjid)
Admin/Bendahara/Viewer hanya lihat data masjid mereka sendiri
Data terpisah per masjid (transaksi, akun, kategori, budget, goal, dll)
Yang Akan Saya Kerjakan:
Step 1: Database Structure
Buat model Masjid
Buat migration untuk table masjids
Tambah kolom masjid_id ke semua table (users, accounts, transactions, categories, budgets, goals, deposits)
Step 2: Global Scope
Implementasi global scope untuk auto-filter data berdasarkan masjid
Super Admin bisa bypass scope ini
Step 3: Masjid Switcher
Buat UI untuk Super Admin switch masjid
Simpan masjid aktif di session
Step 4: Seeder
Seed 3 masjid
Assign user ke masjid masing-masing
Seed sample data per masjid
Step 5: Update Controllers
Otomatis assign masjid_id saat create data
Validasi user hanya bisa akses data masjid mereka