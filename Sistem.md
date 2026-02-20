🧭 PROJECT CONTEXT

Project ini adalah:

Existing Laravel-Based Financial Recording System

Agent AI:

❌ Tidak membuat ulang project
❌ Tidak mengubah arsitektur Laravel utama
❌ Tidak memodifikasi core framework

Agent hanya:

✅ Melakukan UI Redesign (Blade/Tailwind)
✅ Menambahkan Account Management System
✅ Menambahkan Transaction Management System
✅ Menambahkan Calendar Transaction View

🏗 LARAVEL ARCHITECTURE RULES

Agent AI WAJIB MENGIKUTI arsitektur:

MVC Pattern Laravel

Semua logic harus ditempatkan pada:

Layer	Responsibility
Controller	Handle Request
Service Layer	Business Logic
Model	Database Interaction
Migration	Schema
Storage	Proof Image
Blade	UI
📂 REQUIRED DIRECTORY STRUCTURE (NEW)

Agent AI harus membuat:

app/
 └── Services/
      ├── AccountService.php
      └── TransactionService.php

⚠️ Financial Logic:

❌ Tidak boleh di Controller
❌ Tidak boleh di Model
✅ Harus di Service Layer

🏦 ACCOUNT SYSTEM
Model:
App\Models\Account
Migration:
accounts:
- id
- name
- type
- balance (decimal 20,4)
- created_at

Balance harus diolah menggunakan:

Decimal.js

Laravel tidak boleh menggunakan:

float
double
💸 TRANSACTION SYSTEM (CORE FEATURE)
Model:
App\Models\Transaction
Migration:
transactions:
- id
- account_id
- type
- category
- amount (BIGINT)
- note
- proof_image
- transaction_date
- created_at
🧮 MONEY HANDLING RULES

Laravel akan menyimpan:

amount = INTEGER

Contoh:

UI Input	Stored
Rp 1.000	100000
Dinero.js digunakan di:
Frontend Blade + JS

Untuk:

Currency formatting

Representation

Decimal.js digunakan di:
TransactionService.php
AccountService.php

Untuk:

Saldo update

Perhitungan income/expense

🔄 BALANCE UPDATE FLOW

Semua transaksi:

Controller
    ↓
TransactionService
    ↓
Decimal Calculation
    ↓
Update Account Balance
    ↓
Save Transaction
📷 PROOF IMAGE STORAGE

Laravel harus menggunakan:

storage/app/public/transactions

Simpan hanya:

file path

di database:

proof_image

Gunakan:

Storage::disk('public')
📅 CALENDAR VIEW

Kalender:

❌ Tidak memiliki tabel sendiri
✔ Mengambil dari:

transactions.transaction_date

Agent AI harus membuat:

CalendarController

yang:

Fetch transaction by date

Group by day

Filter by account

Return JSON for calendar UI

🚫 STRICTLY PROHIBITED

Agent AI tidak boleh:

Menambahkan Midtrans

Menambahkan Stripe

Menambahkan API Bank

Membuat auto-payment

Menggunakan floating number

Menggunakan payment gateway

Ini adalah:

Manual Financial Recording Laravel System

🎨 UI REDESIGN SCOPE

Agent AI boleh:

✔ Mengubah Blade Layout
✔ Menambahkan Tailwind CDN
✔ Menambahkan Dashboard Chart
✔ Modern UI
✔ Modal Form
✔ Card System

Agent AI tidak boleh:

❌ Mengubah relasi Account ↔ Transaction
❌ Mengubah Financial Flow
❌ Menghilangkan Proof Image

🏁 FINAL SYSTEM TARGET

Laravel MVC Based

Manual Financial Recording

Account Based Transaction

Photo Proof Available

Transaction Calendar

High Precision Calculation

Floating Point Safe

Modern UI Result