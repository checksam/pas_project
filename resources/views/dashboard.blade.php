@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm bg-light pt-4 pb-3 px-4 mb-4">
            <div class="card-body p-0">
                <h1 class="mb-2 text-dark">🏦 Sistem Manajemen Bank</h1>
                <p class="text-secondary fs-5">Selamat datang di aplikasi manajemen bank untuk pembelajaran backend dengan Laravel.</p>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden" style="background: linear-gradient(135deg, #2d8cff 0%, #73b7ff 100%);">
            <div class="card-body text-white">
                <h5 class="card-title">👥 Pegawai</h5>
                <p class="card-text">Kelola data karyawan bank dengan mudah.</p>
                <a href="/pegawai" class="btn btn-outline-light btn-sm">Lihat Data →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden" style="background: linear-gradient(135deg, #2ecc71 0%, #81e1ab 100%);">
            <div class="card-body text-white">
                <h5 class="card-title">💰 Rekening</h5>
                <p class="card-text">Kelola rekening nasabah dengan tampilan yang bersih.</p>
                <a href="/rekening" class="btn btn-outline-light btn-sm">Lihat Data →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden" style="background: linear-gradient(135deg, #f39c12 0%, #f7c45e 100%);">
            <div class="card-body text-white">
                <h5 class="card-title">📝 Transaksi</h5>
                <p class="card-text">Catat transaksi setor dan tarik dengan aman.</p>
                <a href="/transaksi" class="btn btn-outline-light btn-sm">Lihat Data →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 overflow-hidden" style="background: linear-gradient(135deg, #1abc9c 0%, #66d7c5 100%);">
            <div class="card-body text-white">
                <h5 class="card-title">🔄 Transfer</h5>
                <p class="card-text">Proses transfer antar rekening dengan cepat.</p>
                <a href="/transfer" class="btn btn-outline-light btn-sm">Lihat Data →</a>
            </div>
        </div>
    </div>
</div>

<!-- Keterangan Pembelajaran -->
<div class="card mt-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">📚 Keterangan Pembelajaran</h5>
    </div>
    <div class="card-body">
        <h6>BAB 1: Arsitektur & Konfigurasi Framework</h6>
        <ul>
            <li>Aplikasi ini menggunakan pola MVC (Model-View-Controller)</li>
            <li><strong>Models:</strong> Pegawai, Rekening, Transaksi, Transfer (di folder app/Models)</li>
            <li><strong>Views:</strong> Blade templates (di folder resources/views)</li>
            <li><strong>Controllers:</strong> PegawaiController, RekeningController, dll (di folder app/Http/Controllers)</li>
        </ul>

        <h6 class="mt-3">BAB 2: Routing & Logic Handling</h6>
        <ul>
            <li>Routes didaftarkan di file <code>routes/web.php</code></li>
            <li>Menggunakan Resource Controller Routes yang otomatis membuat 7 route CRUD</li>
            <li>Blade Template digunakan untuk templating frontend dengan @@extends, @@yield, @@foreach, @@if</li>
        </ul>

        <h6 class="mt-3">BAB 3: Database, Migration, & Eloquent ORM</h6>
        <ul>
            <li><strong>Migrations:</strong> Struktur tabel dibuat via migration files</li>
            <li><strong>CRUD Operations:</strong> all(), find(), create(), save(), update(), delete()</li>
            <li><strong>Relasi:</strong> One-to-Many (hasMany), Many-to-One (belongsTo)</li>
            <li><strong>Seeder:</strong> Data dummy akan dibuat untuk testing</li>
        </ul>

        <h6 class="mt-3">BAB 4: Keamanan Sistem & Validasi Input</h6>
        <ul>
            <li><strong>CSRF Protection:</strong> @csrf token di setiap form</li>
            <li><strong>Input Validation:</strong> Validasi rules di controller store/update</li>
            <li><strong>SQL Injection Prevention:</strong> Menggunakan Eloquent ORM dan parameterized queries</li>
        </ul>

        <h6 class="mt-3">BAB 5: Middleware & Request Lifecycle</h6>
        <ul>
            <li>Request masuk → Route → Controller → Model → Database</li>
            <li>Response dikembalikan → Controller → View → Browser</li>
            <li>Middleware dapat digunakan untuk validasi auth dan otorisasi</li>
        </ul>
    </div>
</div>

<div class="alert alert-info mt-4">
    <strong>💡 Tips untuk Modifikasi:</strong>
    <ul class="mb-0">
        <li>Ubah struktur field di <code>database/migrations/</code></li>
        <li>Ubah validasi rules di method <code>store()</code> dan <code>update()</code> di Controllers</li>
        <li>Ubah tampilan di <code>resources/views/</code> menggunakan Blade syntax</li>
        <li>Tambah routes baru di <code>routes/web.php</code></li>
        <li>Lihat model relasi untuk memahami One-to-Many dan belongsTo</li>
    </ul>
</div>
@endsection
