@extends('layout')

@section('title', 'Detail Transfer')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Detail Transfer #{{ $transfer->id_transfer }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="mb-3">📤 Data Pengirim</h6>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td><strong>Rekening:</strong></td>
                        <td>{{ $transfer->rekening_pengirim->no_rekening }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $transfer->rekening_pengirim->nama_pemilik }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="mb-3">📥 Data Penerima</h6>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td><strong>Rekening:</strong></td>
                        <td>{{ $transfer->rekening_penerima->no_rekening }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $transfer->rekening_penerima->nama_pemilik }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="card bg-light mb-4">
            <div class="card-body">
                <h6 class="card-title">💰 Detail Transfer</h6>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Jumlah Transfer:</strong></td>
                        <td class="text-end"><h5 class="text-success">Rp {{ number_format($transfer->jumlah, 2, ',', '.') }}</h5></td>
                    </tr>
                    <tr>
                        <td><strong>Biaya Transfer:</strong></td>
                        <td class="text-end">Rp {{ number_format($transfer->biaya_transfer, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Debit Pengirim:</strong></td>
                        <td class="text-end"><h6 class="text-danger">Rp {{ number_format($transfer->jumlah + $transfer->biaya_transfer, 2, ',', '.') }}</h6></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <strong>Tujuan/Keperluan:</strong>
                <p>{{ $transfer->tujuan_transfer }}</p>
            </div>
            <div class="col-md-6">
                <strong>Pegawai:</strong>
                <p>{{ $transfer->pegawai->nama_pegawai }} ({{ $transfer->pegawai->jabatan }})</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <strong>Tanggal Transfer:</strong>
                <p>{{ $transfer->tanggal_transfer->format('d/m/Y H:i:s') }}</p>
            </div>
            <div class="col-md-6">
                <strong>Status:</strong>
                <p>
                    <span class="badge {{ $transfer->status === 'berhasil' ? 'bg-success' : ($transfer->status === 'gagal' ? 'bg-danger' : 'bg-warning') }}">
                        {{ strtoupper($transfer->status) }}
                    </span>
                </p>
            </div>
        </div>

        @if($transfer->catatan)
            <div class="alert alert-info">
                <strong>Catatan:</strong> {{ $transfer->catatan }}
            </div>
        @endif

        <div class="d-flex gap-2">
            @auth
                <a href="/transfer/{{ $transfer->id_transfer }}/edit" class="btn btn-warning">✏️ Update Status</a>
            @endauth
            <a href="/transfer" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</div>

<!-- Keterangan untuk pembelajaran -->
<div class="alert alert-info mt-3">
    <strong>📚 Pembelajaran:</strong>
    <ul class="mb-0">
        <li>Halaman ini menampilkan relasi multiple belongs-to dalam satu record</li>
        <li><code>$transfer->rekening_pengirim</code> dan <code>$transfer->rekening_penerima</code> adalah dua relasi ke tabel yang sama</li>
        <li>Total debit = jumlah transfer + biaya (konsep business logic)</li>
        <li>Transfer dapat di-update statusnya dari pending ke berhasil/gagal</li>
    </ul>
</div>
@endsection
