@extends('layout')

@section('title', 'Detail Pegawai')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Detail Pegawai: {{ $pegawai->nama_pegawai }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>NIP:</strong></td>
                        <td>{{ $pegawai->nip }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $pegawai->nama_pegawai }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jabatan:</strong></td>
                        <td>{{ $pegawai->jabatan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $pegawai->email_pegawai }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td>{{ $pegawai->no_telepon }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="badge {{ $pegawai->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ $pegawai->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Alamat:</strong></td>
                        <td>{{ $pegawai->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <!-- Relasi Data: Transaksi yang dibuat pegawai ini -->
        <h6 class="mb-3">📝 Transaksi yang Diproses</h6>
        @if($pegawai->transaksi->isEmpty())
            <div class="alert alert-info">Belum ada transaksi</div>
        @else
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Rekening</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai->transaksi as $item)
                            <tr>
                                <td>{{ $item->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                                <td>{{ $item->rekening->no_rekening }}</td>
                                <td><span class="badge bg-info">{{ $item->jenis_transaksi }}</span></td>
                                <td>Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <hr>

        <!-- Relasi Data: Transfer yang diproses pegawai ini -->
        <h6 class="mb-3">🔄 Transfer yang Diproses</h6>
        @if($pegawai->transfer->isEmpty())
            <div class="alert alert-info">Belum ada transfer</div>
        @else
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pengirim</th>
                            <th>Penerima</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai->transfer as $item)
                            <tr>
                                <td>{{ $item->tanggal_transfer->format('d/m/Y H:i') }}</td>
                                <td>{{ $item->rekening_pengirim->no_rekening }}</td>
                                <td>{{ $item->rekening_penerima->no_rekening }}</td>
                                <td>Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                <td><span class="badge bg-success">{{ $item->status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <hr>

        <div class="d-flex gap-2">
            @auth
                <a href="/pegawai/{{ $pegawai->id_pegawai }}/edit" class="btn btn-warning">✏️ Edit</a>
            @endauth
            <a href="/pegawai" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</div>

<!-- Keterangan untuk pembelajaran -->
<div class="alert alert-info mt-3">
    <strong>📚 Pembelajaran:</strong>
    <ul class="mb-0">
        <li>Halaman ini menunjukkan relasi One-to-Many: <code>Pegawai hasMany Transaksi</code> dan <code>Pegawai hasMany Transfer</code></li>
        <li><code>$pegawai->transaksi</code> - Mengambil semua transaksi yang dibuat pegawai ini (lazy loading)</li>
        <li><code>@@foreach($pegawai->transaksi as $item)</code> - Iterasi data dari relasi menggunakan Blade</li>
        <li>Data ditampilkan dengan relasi terkait: <code>$item->rekening->no_rekening</code> (nested relasi)</li>
    </ul>
</div>
@endsection
