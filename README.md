# 🏦 Sistem Manajemen Bank - Laravel

Aplikasi pembelajaran backend development menggunakan **Laravel 11** dengan fokus pada analisis logika backend, arsitektur database relasional, dan manipulasi data tingkat lanjut.

## 🚀 Quick Start

### Instalasi
```bash
# 1. Masuk ke folder project
cd hummatech_PAS

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies  
npm install

# 4. Generate encryption key
php artisan key:generate

# 5. Setup database
php artisan migrate:fresh
php artisan db:seed

# 6. Jalankan development server
php artisan serve
```

Buka browser: **http://127.0.0.1:8000**

---

## 📊 Database Schema - 5 Tabel

| Tabel | Deskripsi | Relationship |
|-------|-----------|--------------|
| `users` | User system | 1 → Many Pegawai, Rekening |
| `tbl_pegawai` | Karyawan bank | 1 → Many Transaksi, Transfer |
| `tbl_rekening` | Rekening nasabah | 1 → Many Transaksi, Transfer |
| `tbl_transaksi` | Setor/Tarik/Biaya | Many → 1 Rekening, Pegawai |
| `tbl_transfer` | Transfer antar rekening | Many → 1 Rekening (2x), Pegawai |

---

## 📚 Kisi-Kisi Materi Ujian - 5 BAB

### ✅ BAB 1: Arsitektur & Konfigurasi Framework
- Pola MVC (Model-View-Controller)
- File `.env` untuk kredensial database
- Perintah Artisan CLI

### ✅ BAB 2: Routing & Logic Handling  
- Resource Controller Routes (7 auto routes)
- Blade Templating directives (@extends, @yield, @foreach, @if)
- Parameter dynamic dalam routes

### ✅ BAB 3: Database, Migration, & Eloquent ORM
- Migrations untuk skema database
- CRUD: all(), find(), create(), update(), delete()
- Relasi: hasMany, belongsTo
- Database Seeder

### ✅ BAB 4: Keamanan Sistem & Validasi Input
- Token @csrf
- Validasi input (unique, email, regex, etc)
- SQL Injection prevention
- Password hashing

### ✅ BAB 5: Middleware & Request Lifecycle
- Request flow: Route → Controller → Model → DB → View
- Middleware sebagai filter
- Data flow dari input hingga display

---

## 📁 Project Structure

```
app/Http/Controllers/
├── PegawaiController.php        # CRUD Pegawai
├── RekeningController.php       # CRUD Rekening
├── TransaksiController.php      # Transaksi (no edit)
└── TransferController.php       # Transfer CRUD

app/Models/
├── Pegawai.php                  # HasMany Transaksi, Transfer
├── Rekening.php                 # HasMany Transaksi, Transfer
├── Transaksi.php                # BelongsTo Rekening, Pegawai
└── Transfer.php                 # BelongsTo Rekening (2x), Pegawai

database/migrations/
├── *_create_users_table.php
├── *_create_tbl_pegawai.php
├── *_create_tbl_rekening.php
├── *_create_tbl_transaksi.php
└── *_create_tbl_transfer.php

resources/views/
├── layout.blade.php             # Master layout
├── dashboard.blade.php
├── pegawai/   (index, create, edit, show)
├── rekening/  (index, create, edit, show)
├── transaksi/ (index, create, show)
└── transfer/  (index, create, edit, show)

routes/web.php                   # Resource routes
```

---

## 🔐 Security Features

✅ **CSRF Protection** - @csrf token di setiap form  
✅ **Input Validation** - unique, email, regex rules  
✅ **SQL Injection Prevention** - Eloquent ORM  
✅ **Password Hashing** - Hash::make()  
✅ **Database Transactions** - lockForUpdate untuk consistency  

---

## 🎓 Learning Objectives

- Understand MVC architecture
- Master Eloquent ORM relationships
- Implement CRUD operations
- Use Blade templating
- Validate user input
- Secure applications from common vulnerabilities
- Manage database transactions

---

## 📖 Full Documentation

Lihat **`PANDUAN_MODIFIKASI.md`** untuk:
- Penjelasan detail BAB 1-5
- Contoh kode lengkap
- Cara modifikasi code
- Troubleshooting
- Referensi Laravel

---

## 🧪 Quick Test

```bash
# Test semua fitur
1. Create Pegawai ✓
2. Edit Pegawai ✓
3. Delete Pegawai ✓
4. Create Rekening ✓
5. Transaksi Setor ✓
6. Transaksi Tarik ✓
7. Transfer antar rekening ✓
8. Validasi error ✓
9. Saldo update ✓
```

---

**Framework:** Laravel 11 | **DB:** SQLite | **Created:** June 2025


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
