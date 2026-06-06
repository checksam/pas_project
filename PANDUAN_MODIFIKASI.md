# 🏦 Manajemen Bank - Dokumentasi Project

## Daftar Isi
1. [Struktur Project](#struktur-project)
2. [Instalasi & Setup](#instalasi--setup)
3. [Kisi-Kisi Materi Ujian](#kisi-kisi-materi-ujian)
4. [Panduan Modifikasi Code](#panduan-modifikasi-code)

---

## Struktur Project

```
hummatech_PAS/
├── app/
│   ├── Http/
│   │   └── Controllers/          # Business Logic
│   │       ├── PegawaiController.php
│   │       ├── RekeningController.php
│   │       ├── TransaksiController.php
│   │       └── TransferController.php
│   └── Models/                   # Database Models & Relations
│       ├── User.php
│       ├── Pegawai.php
│       ├── Rekening.php
│       ├── Transaksi.php
│       └── Transfer.php
├── database/
│   ├── migrations/               # Database Schema
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2025_06_06_000001_create_tbl_pegawai.php
│   │   ├── 2025_06_06_000002_create_tbl_rekening.php
│   │   ├── 2025_06_06_000003_create_tbl_transaksi.php
│   │   └── 2025_06_06_000004_create_tbl_transfer.php
│   └── seeders/                  # Data Dummy
│       └── DatabaseSeeder.php
├── resources/
│   └── views/                    # Blade Templates
│       ├── layout.blade.php      # Master Layout
│       ├── dashboard.blade.php
│       ├── pegawai/
│       ├── rekening/
│       ├── transaksi/
│       └── transfer/
├── routes/
│   └── web.php                   # URL Routes
└── config/
    └── app.php                   # Konfigurasi
```

---

## Instalasi & Setup

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Generate APP_KEY
```bash
php artisan key:generate
```

### 3. Setup Database
```bash
# Buat database baru
php artisan migrate:fresh

# Isi dengan data dummy
php artisan db:seed
```

### 4. Jalankan Development Server
```bash
php artisan serve
```

Akses di: `http://127.0.0.1:8000`

### 5. Login (Opsional - jika ada auth)
- Email: `admin@bank.com`
- Password: `password123`

---

## Kisi-Kisi Materi Ujian

### BAB 1: Arsitektur & Konfigurasi Framework

#### MVC Pattern
- **Model** (`app/Models/`) - Berinteraksi dengan database
- **View** (`resources/views/`) - Tampilan frontend
- **Controller** (`app/Http/Controllers/`) - Business logic

#### File Konfigurasi
- `.env` - Menyimpan kredensial database dan konfigurasi
- `config/app.php` - Konfigurasi aplikasi umum

#### Artisan CLI Commands
```bash
php artisan migrate            # Jalankan migrations
php artisan migrate:fresh      # Reset database
php artisan db:seed            # Isi data dummy
php artisan serve              # Start development server
php artisan make:model Nama    # Buat model baru
php artisan make:controller    # Buat controller baru
```

---

### BAB 2: Routing & Logic Handling

#### Resource Routes
**File:** `routes/web.php`

```php
Route::resource('pegawai', PegawaiController::class);
```

Ini otomatis membuat 7 routes:
| Method | URI | Controller Method | Purpose |
|--------|-----|------------------|---------|
| GET | `/pegawai` | index() | List semua data |
| GET | `/pegawai/create` | create() | Form buat baru |
| POST | `/pegawai` | store() | Simpan ke DB |
| GET | `/pegawai/{id}` | show() | Detail satu data |
| GET | `/pegawai/{id}/edit` | edit() | Form edit |
| PUT | `/pegawai/{id}` | update() | Update ke DB |
| DELETE | `/pegawai/{id}` | destroy() | Hapus dari DB |

#### Blade Templating
**File:** `resources/views/pegawai/index.blade.php`

```blade
@extends('layout')              {{-- Inherit layout master --}}
@section('title', 'Pegawai')    {{-- Set page title --}}
@section('content')             {{-- Define content section --}}
    @foreach($pegawai as $item)  {{-- Loop array --}}
        @if($item->status === 'aktif')  {{-- Conditional --}}
            <p>{{ $item->nama }}</p>
        @endif
    @endforeach
@endsection
```

---

### BAB 3: Database, Migration, & Eloquent ORM

#### Migrations
**File:** `database/migrations/2025_06_06_000001_create_tbl_pegawai.php`

```php
Schema::create('tbl_pegawai', function (Blueprint $table) {
    $table->id('id_pegawai');                    // Primary key
    $table->foreignId('user_id')                // Foreign key
           ->constrained('users')
           ->onDelete('cascade');
    $table->string('nama_pegawai', 100);        // String field
    $table->enum('status', ['aktif', 'non-aktif']); // Enum
    $table->timestamps();                       // created_at, updated_at
});
```

#### Eloquent ORM - CRUD Operations
**File:** `app/Models/Pegawai.php`

```php
// CREATE - Buat record baru
$pegawai = Pegawai::create([
    'nip' => '001001',
    'nama_pegawai' => 'Budi',
    // ...
]);

// READ - Ambil data
$semua = Pegawai::all();              // Semua records
$satu = Pegawai::find(1);             // By ID
$cari = Pegawai::where('status', 'aktif')->get();

// UPDATE - Edit record
$pegawai = Pegawai::find(1);
$pegawai->update(['nama_pegawai' => 'Budi Baru']);
// atau
$pegawai->nama_pegawai = 'Budi Baru';
$pegawai->save();

// DELETE - Hapus record
$pegawai->delete();
Pegawai::destroy(1);  // Delete by ID
```

#### Relasi Database
**File:** `app/Models/Pegawai.php`

```php
// One-to-Many Relationship
public function transaksi(): HasMany {
    return $this->hasMany(Transaksi::class, 'id_pegawai');
}

// Belongs-To Relationship
public function user(): BelongsTo {
    return $this->belongsTo(User::class);
}
```

**Penggunaan di Controller:**
```php
$pegawai = Pegawai::find(1);
$transaksi = $pegawai->transaksi;  // Ambil semua transaksi pegawai ini
```

#### Database Seeder
**File:** `database/seeders/DatabaseSeeder.php`

```php
public function run(): void {
    // Buat data dummy otomatis
    User::create(['name' => 'Admin', 'email' => 'admin@mail.com']);
    Pegawai::create(['nip' => '001', 'nama_pegawai' => 'Budi']);
}
```

---

### BAB 4: Keamanan Sistem & Validasi Input

#### CSRF Protection
**File:** `resources/views/pegawai/create.blade.php`

```blade
<form action="/pegawai" method="POST">
    @csrf  {{-- Menambah CSRF token untuk keamanan --}}
    <input type="text" name="nama">
    <button type="submit">Simpan</button>
</form>
```

#### Input Validation
**File:** `app/Http/Controllers/PegawaiController.php`

```php
public function store(Request $request) {
    // Validasi input sebelum masuk database
    $validated = $request->validate([
        'nip' => 'required|string|max:20|unique:tbl_pegawai,nip',
        'nama_pegawai' => 'required|string|max:100',
        'email_pegawai' => 'required|email|unique:tbl_pegawai',
        'status' => 'required|in:aktif,non-aktif',
    ]);
    
    // Data yang sudah valid
    Pegawai::create($validated);
}
```

**Validasi di View:**
```blade
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@error('email_pegawai')
    <span class="text-danger">{{ $message }}</span>
@enderror
```

#### SQL Injection Prevention
Menggunakan Eloquent ORM mencegah SQL Injection:

```php
// ❌ TIDAK AMAN - Raw query
$data = DB::select("SELECT * FROM pegawai WHERE nip = '" . $nip . "'");

// ✅ AMAN - Eloquent/Parameterized query
$data = Pegawai::where('nip', $nip)->get();
```

#### Password Hashing
```php
// Hash password sebelum simpan
$user = User::create([
    'password' => Hash::make('password123'),  // Encrypt password
]);

// Verify password saat login
if (Hash::check('password123', $user->password)) {
    // Password cocok
}
```

---

### BAB 5: Middleware & Request Lifecycle

#### Request Lifecycle

```
1. Request masuk (Browser)
   ↓
2. Route Matching (routes/web.php)
   ↓
3. Controller Method (app/Http/Controllers/)
   ↓
4. Model Query (app/Models/)
   ↓
5. Database Query
   ↓
6. View Rendering (resources/views/)
   ↓
7. Response ke Browser
```

#### Contoh Flow: Create Pegawai Baru

**User Input di Form:**
```
GET /pegawai/create → PegawaiController::create()
```

**Jalankan Transaksi:**
```
POST /pegawai → PegawaiController::store()
  ↓
$validated = $request->validate()     // Validasi input
  ↓
Pegawai::create($validated)           // Simpan ke DB (Eloquent ORM)
  ↓
redirect('/pegawai')                  // Redirect ke index
```

#### Middleware (Opsional)
```php
// Proteksi route dengan auth middleware
Route::middleware(['auth'])->group(function () {
    Route::resource('pegawai', PegawaiController::class);
});
```

---

## Panduan Modifikasi Code

### 1. Menambah Field Baru di Table

**Langkah 1:** Buat migration baru
```bash
php artisan make:migration add_no_rek_pegawai_to_pegawai --table=tbl_pegawai
```

**Langkah 2:** Edit migration file
```php
public function up(): void {
    Schema::table('tbl_pegawai', function (Blueprint $table) {
        $table->string('no_rek_pegawai', 20)->nullable();
    });
}
```

**Langkah 3:** Jalankan migration
```bash
php artisan migrate
```

**Langkah 4:** Update Model (tambah di `$fillable`)
```php
// app/Models/Pegawai.php
protected $fillable = [
    'user_id',
    'nip',
    'nama_pegawai',
    'no_rek_pegawai',  // Field baru
    // ...
];
```

**Langkah 5:** Update Controller (tambah di validation)
```php
public function store(Request $request) {
    $validated = $request->validate([
        'no_rek_pegawai' => 'nullable|string|max:20',
        // ...
    ]);
}
```

**Langkah 6:** Update Views (tambah input field)
```blade
<input type="text" name="no_rek_pegawai" class="form-control">
```

### 2. Menambah Validasi Rules

**File:** `app/Http/Controllers/PegawaiController.php`

```php
$validated = $request->validate([
    'nip' => 'required|string|max:20|unique:tbl_pegawai,nip|regex:/^[0-9]+$/',  // NIP harus angka
    'nama_pegawai' => 'required|string|min:3|max:100',  // Min 3 karakter
    'email_pegawai' => 'required|email',
    'no_telepon' => 'required|regex:/^62|^08/',  // Nomor telp Indonesia
]);
```

**Validasi Rules yang Umum:**
- `required` - Field wajib diisi
- `email` - Format email valid
- `unique:table,column` - Nilai unik di table
- `min:5` / `max:100` - Minimal/maksimal
- `numeric` - Hanya angka
- `regex:/pattern/` - Regex pattern
- `confirmed` - Match dengan field `_confirmation`
- `in:value1,value2` - Salah satu dari list

### 3. Mengubah Tipe Relasi

Dari One-to-Many ke Many-to-Many:

```php
// Model Pegawai
public function transaksi() {
    // One-to-Many (saat ini)
    return $this->hasMany(Transaksi::class);
    
    // Many-to-Many (jika ingin ubah)
    // return $this->belongsToMany(Transaksi::class, 'pivot_table');
}
```

### 4. Menambah Custom Method di Controller

```php
public function laporan() {
    // Custom action yang tidak ada di 7 resource actions
    $transaksi = Transaksi::all();
    $total = $transaksi->sum('jumlah');
    return view('transaksi.laporan', compact('total'));
}
```

**Tambah route:**
```php
Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan']);
```

---

## Testing

### Manual Testing Checklist

- [ ] Create Pegawai baru
- [ ] Edit Pegawai
- [ ] Hapus Pegawai
- [ ] Create Rekening
- [ ] Lakukan Transaksi (setor)
- [ ] Lakukan Transaksi (tarik)
- [ ] Lakukan Transfer
- [ ] Validasi error (isi form tidak lengkap)
- [ ] Validasi unique field (NIP/Email duplikat)
- [ ] Cek saldo sebelum-sesudah transaksi

---

## Troubleshooting

| Error | Solusi |
|-------|--------|
| `Class not found` | Pastikan sudah `composer install` |
| `SQLSTATE[HY000]` | Cek database config di `.env` |
| `View not found` | Cek path file view, case-sensitive |
| `No table found` | Jalankan `php artisan migrate` |
| `Column not found` | Update model $fillable atau jalankan migration |

---

## Referensi Tambahan

- [Laravel Documentation](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Blade Templating](https://laravel.com/docs/blade)
- [Validation](https://laravel.com/docs/validation)

---

**Dibuat untuk:** Kelas XI - Manajemen Bank  
**Framework:** Laravel 11  
**Database:** SQLite  
**Date:** June 2025
