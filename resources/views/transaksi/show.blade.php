@extends('layout')

@section('title', 'Detail Transaksi')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Detail Transaksi #{{ $transaksi->id_transaksi }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID Transaksi:</strong></td>
                        <td>{{ $transaksi->id_transaksi }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal:</strong></td>
                        <td>{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Transaksi:</strong></td>
                        <td>
                            <span class="badge {{ $transaksi->jenis_transaksi === 'setor' ? 'bg-success' : ($transaksi->jenis_transaksi === 'tarik' ? 'bg-danger' : 'bg-warning') }}">
                                {{ strtoupper($transaksi->jenis_transaksi) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Rekening:</strong></td>
                        <td>{{ $transaksi->rekening->no_rekening }} - {{ $transaksi->rekening->nama_pemilik }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pegawai:</strong></td>
                        <td>{{ $transaksi->pegawai->nama_pegawai }} ({{ $transaksi->pegawai->jabatan }})</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card bg-light mb-4">
            <div class="card-body">
                <h6 class="card-title">Detail Transaksi Keuangan</h6>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Jumlah Transaksi:</strong></td>
                                <td class="text-end"><h6 class="text-danger">Rp {{ number_format($transaksi->jumlah, 2, ',', '.') }}</h6></td>
                            </tr>
                            <tr>
                                <td><strong>Saldo Sebelum:</strong></td>
                                <td class="text-end">Rp {{ number_format($transaksi->saldo_sebelum, 2, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Saldo Sesudah:</strong></td>
                                <td class="text-end"><h6 class="text-success">Rp {{ number_format($transaksi->saldo_sesudah, 2, ',', '.') }}</h6></td>
                            </tr>
                            <tr>
                                <td><strong>Perubahan:</strong></td>
                                <td class="text-end">
                                    @if($transaksi->jenis_transaksi === 'setor')
                                        <span class="badge bg-success">+Rp {{ number_format($transaksi->jumlah, 2, ',', '.') }}</span>
                                    @else
                                        <span class="badge bg-danger">-Rp {{ number_format($transaksi->jumlah, 2, ',', '.') }}</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($transaksi->keterangan)
            <div class="alert alert-info">
                <strong>Keterangan:</strong> {{ $transaksi->keterangan }}
            </div>
        @endif

        <div class="d-flex gap-2">
            <a href="/transaksi" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</div>

<!-- Keterangan untuk pembelajaran -->
<div class="alert alert-info mt-3">
    <strong>📚 Pembelajaran:</strong>
    <ul class="mb-0">
        <li>Halaman ini menampilkan data transaksi dengan relasi terkait (rekening dan pegawai)</li>
        <li>Data saldo before-after digunakan untuk audit trail dan verifikasi data</li>
        <li>Demonstrasi penggunaan <code>number_format()</code> untuk formatting currency</li>
        <li>Transaksi adalah read-only data, tidak bisa diedit, hanya dihapus</li>
    </ul>
</div>
@endsection
